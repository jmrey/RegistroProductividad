<?php

class TesisController extends AppController {
    public $name = 'Tesis';
    public $components = array('Session');
    public $uses = array('Tesis');
    
    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow('json_index');
    }
    
    public function index() {
        $this->Tesis->recursive = -1;
        $tesis = $this->Tesis->findAllByUserId($this->Auth->user('id'));
        $this->set('tipo_tesis', $this->Tesis->tipoTesis);
        $this->set('tesis', $tesis);
    }
    
    public function admin_index() {
        $this->Tesis->recursive = -1;
        $this->set('tesis', $this->paginate());
    }
    
    /*public function json_index($field = null, $query = null) {
        $this->autoRender = false;
        $conditions = array(
            'conditions' => array('Articulo.' . $field . ' LIKE' => '%' . $query .'%'),
            'fields' => 'DISTINCT Articulo.' . $field,
            'order' => 'Articulo.' . $field,
        );
        
        $results = $this->Tesis->find('all', $conditions);
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
        $this->set('tipo_tesis', $this->Tesis->tipoTesis);
        if ($this->request->is('post')) {
            $this->Tesis->create();
            $this->request->data['Tesis']['user_id'] = $this->Auth->user('id');
            if ($this->Tesis->save($this->request->data)) {
                $this->success('Se ha registrado la tesis satisfactoriamente.');
                $this->redirect('/tesis/' . $this->Tesis->id . '/archivos');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    public function ver($id = null) {
        $this->Tesis->id = isset($id) ? $id : $this->request->params['id'];
        if (!$this->Tesis->exists()) {
            throw new NotFoundException('Tesis que buscas no existe.');
        } else {
            $this->Tesis->recursive = -1;
            $tesis = $this->Tesis->read(null, $id);
            $this->set('tipo_tesis', $this->Tesis->tipoTesis);
            $this->set('tesis', $tesis);
        }
    }
    
    public function editar($id = null) {
        $this->Tesis->id = $id;
        if (!$this->Tesis->exists()) {
            throw new NotFoundException('Articulo no existe.');
        }
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        $this->set('tipo_tesis', $this->Tesis->tipoTesis);
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Tesis->save($this->request->data)) {
                $this->request->data['Tesis']['id'] = $id;
                $this->success('Se han actualizado los datos.');
            } else {
                $this->error('No se han podido guardar los datos.');
            }
        } else {
            $this->Tesis->recursive = -1;
            $this->request->data = $this->Tesis->read(null, $id);
        }
    }
    
    public function borrar($id = null) {
        $this->autoRender = false;
        
        if (!($this->request->is('post') || $this->request->is('delete'))) {
            throw new MethodNotAllowedException();
        }
        $this->Tesis->id = $id;
        if (!$this->Tesis->exists()) {
            throw new NotFoundException('Tesis no existe o ya ha sido borrada.');
        }
        
        $isOwnedBy = $this->Tesis->isOwnedBy($id, $this->Auth->user('id'));
        if ($isOwnedBy) {
            if ($this->Tesis->delete()) {
                $this->success('La Tesis ha sido borrada.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->error('La Tesis no se ha podido borrar.');
            }
        } else {
            $this->error('No tienes los permisos para esta acción.');
            $this->redirect(array('action' => 'index'));
        }
        //$this->redirect(array('action' => 'index'));
    }
    
    public function exportar($type = null) {
        $this->Tesis->recursive = -1;
        $results = $this->Tesis->findAllByUserId($this->Auth->user('id'));
        $this->set('tipo_tesis', $this->Tesis->tipoTesis);
        $this->_exportar($results, $type);
    }
}
?>
