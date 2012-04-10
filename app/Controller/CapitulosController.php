<?php

class CapitulosController extends AppController {
    public $name = 'Capitulos';
    public $components = array('Session');
    public $uses = array('Capitulo', 'Contenido');
    public $helpers = array('AjaxMultiUpload.Upload');
    
    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow('add', 'login', 'logout');
    }
    
    public function index() {
        $this->Capitulo->recursive = -1;
        $capitulos = $this->Capitulo->findAllByUserId($this->Auth->user('id'));
        $this->set('capitulos', $capitulos);
    }
    
    public function admin_index() {
        $this->Capitulo->recursive = -1;
        $this->set('capitulos', $this->paginate());
    }
    
    /*public function json_index($field = null, $query = null) {
        $this->autoRender = false;
        $conditions = array(
            'conditions' => array('Capitulo.' . $field . ' LIKE' => '%' . $query .'%'),
            'fields' => 'DISTINCT Capitulo.' . $field,
            'order' => 'Capitulo.' . $field,
        );
        
        $results = $this->Capitulo->find('all', $conditions);
        $json_array = array();
        foreach ($results as $key => $value) {
            array_push($json_array, $value['Capitulo'][$field]);
        }
        echo json_encode($json_array);
    }*/
    
    public function nuevo() {
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        if ($this->request->is('post')) {
            $this->Capitulo->create();
            $this->request->data['Capitulo']['user_id'] = $this->Auth->user('id');
            if ($this->Capitulo->save($this->request->data)) {
                $this->success('Se ha registrado el artículo satisfactoriamente.');
                $this->redirect('/capitulos/' . $this->Capitulo->id . '/archivos');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    public function ver($id = null) {
        $this->Capitulo->id = isset($id) ? $id : $this->request->params['id'];
        if (!$this->Capitulo->exists()) {
            throw new NotFoundException('Capitulo que buscas no existe.');
        } else {
            $this->Capitulo->recursive = -1;
            $capitulo = $this->Capitulo->read(null, $id);
            $this->set('capitulo', $capitulo);
        }
    }
    
    public function editar($id = null) {
        $this->Capitulo->id = $id;
        if (!$this->Capitulo->exists()) {
            throw new NotFoundException('Capitulo no existe.');
        }
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Capitulo->save($this->request->data)) {
                $this->request->data['Capitulo']['id'] = $id;
                $this->success('Se han actualizado los datos.');
            } else {
                $this->error('No se han podido guardar los datos.');
            }
        } else {
            $this->Capitulo->recursive = -1;
            $this->request->data = $this->Capitulo->read(null, $id);
        }
    }
    
    public function borrar($id = null) {
        $this->autoRender = false;
        
        if (!($this->request->is('post') || $this->request->is('delete'))) {
            throw new MethodNotAllowedException();
        }
        $this->Capitulo->id = $id;
        if (!$this->Capitulo->exists()) {
            throw new NotFoundException('Capitulo no existe o ya ha sido borrado.');
        }
        
        $isOwnedBy = $this->Capitulo->isOwnedBy($id, $this->Auth->user('id'));
        if ($isOwnedBy) {
            if ($this->Capitulo->delete()) {
                $this->success('El capítulo ha sido borrado.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->error('El capítulo no se ha podido borrar.');
            }
        } else {
            $this->error('No tienes los permisos para está acción.');
            $this->redirect(array('action' => 'index'));
        }
        //$this->redirect(array('action' => 'index'));
    }
    
    public function exportar($type = null) {
        $this->Capitulo->recursive = -1;
        $results = $this->Capitulo->findAllByUserId($this->Auth->user('id'));
        $this->_exportar($results, $type);
    }
}
?>
