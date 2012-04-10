<?php

class LibrosController extends AppController {
    public $name = 'Libros';
    public $components = array('Session');
     public $uses = array('Libro', 'Contenido');
     public $helpers = array('AjaxMultiUpload.Upload');
    
    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow('add', 'login', 'logout');
    }
    
    public function index() {
        $this->Libro->recursive = -1;
        $libros = $this->Libro->findAllByUserId($this->Auth->user('id'));
        $this->set('tipo_libros', $this->Libro->tipoLibros);
        $this->set('libros', $libros);
    }
    
    public function admin_index() {
        $this->Libro->recursive = -1;
        $this->set('libros', $this->paginate());
    }
    
    /*public function json_index($field = null, $query = null) {
        $this->autoRender = false;
        $conditions = array(
            'conditions' => array('Libro.' . $field . ' LIKE' => '%' . $query .'%'),
            'fields' => 'DISTINCT Libro.' . $field,
            'order' => 'Libro.' . $field,
        );
        
        $results = $this->Libro->find('all', $conditions);
        $json_array = array();
        foreach ($results as $key => $value) {
            array_push($json_array, $value['Libro'][$field]);
        }
        echo json_encode($json_array);
    }*/
    
    public function nuevo() {
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        $this->set('tipo_libros', $this->Libro->tipoLibros);
        if ($this->request->is('post')) {
            $this->Libro->create();
            $this->request->data['Libro']['user_id'] = $this->Auth->user('id');
            if ($this->Libro->save($this->request->data)) {
                $this->success('Se ha registrado el artículo satisfactoriamente.');
                $this->redirect('/libros/' . $this->Libro->id . '/archivos');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    public function ver($id = null) {
        $this->Libro->id = isset($id) ? $id : $this->request->params['id'];
        if (!$this->Libro->exists()) {
            throw new NotFoundException('Libro que buscas no existe.');
        } else {
            $this->Libro->recursive = -1;
            $libro = $this->Libro->read(null, $id);
            $this->set('libro', $libro);
        }
    }
    
    public function editar($id = null) {
        $this->set('tipo_libros', $this->Libro->tipoLibros);
        $this->Libro->id = $id;
        if (!$this->Libro->exists()) {
            throw new NotFoundException('Libro no existe.');
        }
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Libro']['id'] = $id;
            if ($this->Libro->save($this->request->data)) {
                $this->success('Se han actualizado los datos.');
            } else {
                $this->error('No se han podido guardar los datos.');
            }
        } else {
            $this->Libro->recursive = -1;
            $this->request->data = $this->Libro->read(null, $id);
        }
    }
    
    public function borrar($id = null) {
        $this->autoRender = false;
        
        if (!($this->request->is('post') || $this->request->is('delete'))) {
            throw new MethodNotAllowedException();
        }
        $this->Libro->id = $id;
        if (!$this->Libro->exists()) {
            throw new NotFoundException('Libro no existe o ya ha sido borrado.');
        }
        
        $isOwnedBy = $this->Libro->isOwnedBy($id, $this->Auth->user('id'));
        if ($isOwnedBy) {
            if ($this->Libro->delete()) {
                $this->success('El libro ha sido borrado.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->error('El libro no se ha podido borrar.');
            }
        } else {
            $this->error('No tienes los permisos para está acción.');
            $this->redirect(array('action' => 'index'));
        }
        //$this->redirect(array('action' => 'index'));
    }
    
    public function exportar($type = null) {
        $this->Libro->recursive = -1;
        $results = $this->Libro->findAllByUserId($this->Auth->user('id'));
        $this->set('tipo_libros', $this->Libro->tipoLibros);
        $this->_exportar($results, $type);
    }
}
?>
