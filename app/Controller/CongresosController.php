<?php

class CongresosController extends AppController {
    public $name = 'Congresos';
    public $components = array('Session');
    
    public $paginate = array(
        'limit' => 20,
        'order' => array(
            'Congreso.anio_publicacion' => 'asc',
            'Congreso.nombre' => 'asc'
        )
    );
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('json_index');
    }
    
    public function index() {
        $this->Congreso->recursive = -1;
        $this->paginate['conditions'] = array('Congreso.user_id' => $this->Auth->user('id'));
        $congresos = $this->paginate();
        $this->set('tipo_congreso', $this->Congreso->tipoCongreso);
        $this->set('congresos', $congresos);
    }
    
    public function admin_index() {
        $this->Congreso->recursive = -1;
        $this->set('tipo_congreso', $this->Congreso->tipoCongreso);
        $this->set('congresos', $this->paginate());
    }
    
    public function json_index($field = null, $query = null) {
        $this->autoRender = false;
        $conditions = array(
            'conditions' => array('Articulo.' . $field . ' LIKE' => '%' . $query .'%'),
            'fields' => 'DISTINCT Articulo.' . $field,
            'order' => 'Articulo.' . $field,
        );
        
        $results = $this->Congreso->find('all', $conditions);
        $json_array = array();
        foreach ($results as $key => $value) {
            array_push($json_array, $value['Articulo'][$field]);
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
        $this->set('tipo_congreso', $this->Congreso->tipoCongreso);
        if ($this->request->is('post')) {
            $this->Congreso->create();
            $this->request->data['Congreso']['user_id'] = $this->Auth->user('id');
            if ($this->Congreso->save($this->request->data)) {
                $this->success('Se ha registrado el congreso satisfactoriamente.');
                $this->redirect('/congresos/' . $this->Congreso->id . '/archivos');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    public function ver($id = null) {
        $this->Congreso->id = isset($id) ? $id : $this->request->params['id'];
        if (!$this->Congreso->exists()) {
            throw new NotFoundException('Articulo que buscas no existe.');
        } else {
            $this->Congreso->recursive = -1;
            $congreso = $this->Congreso->read(null, $id);
            $this->set('tipo_congreso', $this->Congreso->tipoCongreso);
            $this->set('congreso', $congreso);
        }
    }
    
    public function editar($id = null) {
        $this->Congreso->id = $id;
        if (!$this->Congreso->exists()) {
            throw new NotFoundException('Articulo no existe.');
        }
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        $this->set('tipo_congreso', $this->Congreso->tipoCongreso);
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Congreso->save($this->request->data)) {
                $this->request->data['Congreso']['id'] = $id;
                $this->success('Se han actualizado los datos.');
            } else {
                $this->error('No se han podido guardar los datos.');
            }
        } else {
            $this->Congreso->recursive = -1;
            $this->request->data = $this->Congreso->read(null, $id);
        }
    }
    
    public function borrar($id = null) {
        $this->autoRender = false;
        
        if (!($this->request->is('post') || $this->request->is('delete'))) {
            throw new MethodNotAllowedException();
        }
        $this->Congreso->id = $id;
        if (!$this->Congreso->exists()) {
            throw new NotFoundException('Congreso no existe o ya ha sido borrado.');
        }
        
        $isOwnedBy = $this->Congreso->isOwnedBy($id, $this->Auth->user('id'));
        if ($isOwnedBy) {
            if ($this->Congreso->delete()) {
                $this->success('El Congreso ha sido borrado.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->error('El Congreso no se ha podido borrar.');
            }
        } else {
            $this->error('No tienes los permisos para está acción.');
            $this->redirect(array('action' => 'index'));
        }
        //$this->redirect(array('action' => 'index'));
    }
    
    public function search() {
        $query = $this->params['url']['q'];
        if (!$query) {
            $this->set('congresos', array());
        } else {
            $this->set('congresos', $this->Congreso->findByQuery($query, $this->Auth->user('id')));
        }
        $this->set('tipo_congreso', $this->Congreso->tipoCongreso);
        $this->render('index');
    }
    
    public function exportar($type = null) {
        $this->Congreso->recursive = -1;
        $results = $this->Congreso->findAllByUserId($this->Auth->user('id'));
        $this->set('tipo_congreso', $this->Congreso->tipoCongreso);
        $this->_exportar($results, $type);
    }
}
?>
