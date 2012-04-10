<?php

class ArticulosController extends AppController {
    public $name = 'Articulos';
    public $components = array('Session');
    //public $uses = array('Articulo', 'Contenido');
    public $helpers = array('AjaxMultiUpload.Upload');
    
    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow('json_index');
    }
    
    public function index() {
        $this->Articulo->recursive = -1;
        $articulos = $this->Articulo->findAllByUserId($this->Auth->user('id'));
        $this->set('articulos', $articulos);
    }
    
    public function admin_index() {
        $this->Articulo->recursive = -1;
        $this->set('articulos', $this->paginate());
    }
    
    /*public function json_index($field = null, $query = null) {
        $this->autoRender = false;
        $conditions = array(
            'conditions' => array('Articulo.' . $field . ' LIKE' => '%' . $query .'%'),
            'fields' => 'DISTINCT Articulo.' . $field,
            'order' => 'Articulo.' . $field,
        );
        
        $results = $this->Articulo->find('all', $conditions);
        $json_array = array();
        foreach ($results as $key => $value) {
            array_push($json_array, $value['Articulo'][$field]);
        }
        echo json_encode($json_array);
    }*/
    
    public function nuevo() {
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        if ($this->request->is('post')) {
            $this->Articulo->create();
            $this->request->data['Articulo']['user_id'] = $this->Auth->user('id');
            if ($this->Articulo->save($this->request->data)) {
                $this->success('Se ha registrado el artículo satisfactoriamente.');
                $this->redirect('/articulos/' . $this->Articulo->id . '/archivos');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    public function ver($id = null) {
        $this->Articulo->id = isset($id) ? $id : $this->request->params['id'];
        if (!$this->Articulo->exists()) {
            throw new NotFoundException('Articulo que buscas no existe.');
        } else {
            $this->Articulo->recursive = -1;
            $articulo = $this->Articulo->read(null, $id);
            $this->set('articulo', $articulo);
        }
    }
    
    public function editar($id = null) {
        $this->Articulo->id = $id;
        if (!$this->Articulo->exists()) {
            throw new NotFoundException('Articulo no existe.');
        }
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Articulo->save($this->request->data)) {
                $this->request->data['Articulo']['id'] = $id;
                $this->success('Se han actualizado los datos.');
            } else {
                $this->error('No se han podido guardar los datos.');
            }
        } else {
            $this->Articulo->recursive = -1;
            $this->request->data = $this->Articulo->read(null, $id);
        }
    }
    
    public function borrar($id = null) {
        $this->autoRender = false;
        
        if (!($this->request->is('post') || $this->request->is('delete'))) {
            throw new MethodNotAllowedException();
        }
        $this->Articulo->id = $id;
        if (!$this->Articulo->exists()) {
            throw new NotFoundException('Articulo no existe o ya ha sido borrado.');
        }
        
        $isOwnedBy = $this->Articulo->isOwnedBy($id, $this->Auth->user('id'));
        if ($isOwnedBy) {
            if ($this->Articulo->delete()) {
                $this->success('El articulo ha sido borrado.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->error('El articulo no se ha podido borrar.');
            }
        } else {
            $this->error('No tienes los permisos para esta acción.');
            $this->redirect(array('action' => 'index'));
        }
        //$this->redirect(array('action' => 'index'));
    }
    
    public function exportar($type = null) {
        $this->Articulo->recursive = -1;
        $results = $this->Articulo->findAllByUserId($this->Auth->user('id'));
        $this->_exportar($results, $type);
    }
}
?>
