<?php

class PatentesController extends AppController {
    public $name = 'Patentes';
    public $components = array('Session');
    //public $uses = array('Patente', 'Contenido');
    
    public $paginate = array(
        'limit' => 20,
        'order' => array(
            'Patente.fecha_presentacion' => 'asc',
            'Patente.titulo' => 'asc'
        )
    );
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('title_for_layout', $this->name);
        $this->set('estado_patentes', $this->Patente->estadoPatentes);
        $this->set('tipo_patentes', $this->Patente->tipoPatentes);
        //$this->Auth->allow('json_index');
    }
    
    public function index() {
        $this->Patente->recursive = -1;
        $this->paginate['conditions'] = array('Patente.user_id' => $this->Auth->user('id'));
        $patentes = $this->paginate();
        $this->set('patentes', $patentes);
    }
    
    public function admin_index() {
        $this->Patente->recursive = -1;
        $this->set('patentes', $this->paginate());
    }
    
    public function json_index($field = null, $query = null) {
        $this->autoRender = false;
        $conditions = array(
            'conditions' => array('Patente.' . $field . ' LIKE' => '%' . $query .'%'),
            'fields' => 'DISTINCT Patente.' . $field,
            'order' => 'Patente.' . $field,
        );
        
        $results = $this->Patente->find('all', $conditions);
        $json_array = array();
        foreach ($results as $key => $value) {
            array_push($json_array, $value['Patente'][$field]);
        }
        echo json_encode($json_array);
    }
    
    public function nuevo() {
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        if ($this->request->is('post')) {
            $this->Patente->create();
            $this->request->data['Patente']['user_id'] = $this->Auth->user('id');
            if ($this->Patente->save($this->request->data)) {
                $this->success('Se ha registrado el artículo satisfactoriamente.');
                $this->redirect('/patentes/' . $this->Patente->id . '/archivos');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    public function ver($id = null) {
        $this->Patente->id = isset($id) ? $id : $this->request->params['id'];
        if (!$this->Patente->exists()) {
            throw new NotFoundException('Patente que buscas no existe.');
        } else {
            $this->Patente->recursive = -1;
            $patente = $this->Patente->read(null, $id);
            $this->set('patente', $patente);
        }
    }
    
    public function editar($id = null) {
        $this->Patente->id = $id;
        if (!$this->Patente->exists()) {
            throw new NotFoundException('Patente no existe.');
        }
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Patente->save($this->request->data)) {
                $this->request->data['Patente']['id'] = $id;
                $this->success('Se han actualizado los datos.');
            } else {
                $this->error('No se han podido guardar los datos.');
            }
        } else {
            $this->Patente->recursive = -1;
            $this->request->data = $this->Patente->read(null, $id);
        }
    }
    
    public function borrar($id = null) {
        $this->autoRender = false;
        
        if (!($this->request->is('post') || $this->request->is('delete'))) {
            throw new MethodNotAllowedException();
        }
        $this->Patente->id = $id;
        if (!$this->Patente->exists()) {
            throw new NotFoundException('Patente no existe o ya ha sido borrado.');
        }
        
        $isOwnedBy = $this->Patente->isOwnedBy($id, $this->Auth->user('id'));
        if ($isOwnedBy) {
            if ($this->Patente->delete()) {
                $this->success('La patente ha sido borrado.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->error('La patente no se ha podido borrar.');
            }
        } else {
            $this->error('No tienes los permisos para esta acción.');
            $this->redirect(array('action' => 'index'));
        }
        //$this->redirect(array('action' => 'index'));
    }
    
    public function search() {
        $query = $this->params['url']['q'];
        if (!$query) {
            $this->set('patentes', array());
        } else {
            $this->set('patentes', $this->Patente->findByQuery($query, $this->Auth->user('id')));
        }
        $this->render('index');
    }
    
    public function exportar($type = null) {
        $this->Patente->recursive = -1;
        $results = $this->Patente->findAllByUserId($this->Auth->user('id'));
        $this->_exportar($results, $type);
    }
    
    public function admin_exportar($type = null) {
        $this->Patente->recursive = -1;
        $results = $this->Patente->find('all');
        $this->_exportar($results, $type);
    }
}
?>
