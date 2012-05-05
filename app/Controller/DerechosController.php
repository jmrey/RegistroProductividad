<?php

class DerechosController extends AppController {
    public $name = 'Derechos';
    public $components = array('Session');
    //public $uses = array('Derecho', 'Contenido');
    
    public $paginate = array(
        'limit' => 20,
        'order' => array(
            'Derecho.fecha_presentacion' => 'asc',
            'Derecho.titulo' => 'asc'
        )
    );
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('title_for_layout', $this->name . ' de Autor');
        //$this->Auth->allow('json_index');
    }
    
    public function index() {
        $this->Derecho->recursive = -1;
        $this->paginate['conditions'] = array('Derecho.user_id' => $this->Auth->user('id'));
        $derechos = $this->paginate();
        $this->set('derechos', $derechos);
    }
    
    public function admin_index() {
        $this->Derecho->recursive = -1;
        $this->set('derechos', $this->paginate());
    }
    
    public function json_index($field = null, $query = null) {
        $this->autoRender = false;
        $conditions = array(
            'conditions' => array('Derecho.' . $field . ' LIKE' => '%' . $query .'%'),
            'fields' => 'DISTINCT Derecho.' . $field,
            'order' => 'Derecho.' . $field,
        );
        
        $results = $this->Derecho->find('all', $conditions);
        $json_array = array();
        foreach ($results as $key => $value) {
            array_push($json_array, $value['Derecho'][$field]);
        }
        echo json_encode($json_array);
    }
    
    public function nuevo() {
        if ($this->request->is('post')) {
            $this->Derecho->create();
            $this->request->data['Derecho']['user_id'] = $this->Auth->user('id');
            if ($this->Derecho->save($this->request->data)) {
                $this->success('Se ha registrado el derecho de autor satisfactoriamente.');
                $this->redirect('/derechos/' . $this->Derecho->id . '/archivos');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    public function ver($id = null) {
        $this->Derecho->id = isset($id) ? $id : $this->request->params['id'];
        if (!$this->Derecho->exists()) {
            throw new NotFoundException('Derecho que buscas no existe.');
        } else {
            $this->Derecho->recursive = -1;
            $derecho = $this->Derecho->read(null, $id);
            $this->set('derecho', $derecho);
        }
    }
    
    public function editar($id = null) {
        $this->Derecho->id = $id;
        if (!$this->Derecho->exists()) {
            throw new NotFoundException('Derecho no existe.');
        }
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Derecho->save($this->request->data)) {
                $this->request->data['Derecho']['id'] = $id;
                $this->success('Se han actualizado los datos.');
            } else {
                $this->error('No se han podido guardar los datos.');
            }
        } else {
            $this->Derecho->recursive = -1;
            $this->request->data = $this->Derecho->read(null, $id);
        }
    }
    
    public function borrar($id = null) {
        $this->autoRender = false;
        
        if (!($this->request->is('post') || $this->request->is('delete'))) {
            throw new MethodNotAllowedException();
        }
        $this->Derecho->id = $id;
        if (!$this->Derecho->exists()) {
            throw new NotFoundException('Derecho no existe o ya ha sido borrado.');
        }
        
        $isOwnedBy = $this->Derecho->isOwnedBy($id, $this->Auth->user('id'));
        if ($isOwnedBy) {
            if ($this->Derecho->delete()) {
                $this->success('La derecho ha sido borrado.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->error('La derecho no se ha podido borrar.');
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
            $this->set('derechos', array());
        } else {
            $this->set('derechos', $this->Derecho->findByQuery($query, $this->Auth->user('id')));
        }
        $this->render('index');
    }
    
    public function exportar($type = null) {
        $this->Derecho->recursive = -1;
        $results = $this->Derecho->findAllByUserId($this->Auth->user('id'));
        $this->_exportar($results, $type);
    }
    
    public function admin_exportar($type = null) {
        $this->Derecho->recursive = -1;
        $results = $this->Derecho->find('all');
        $this->_exportar($results, $type);
    }
}
?>
