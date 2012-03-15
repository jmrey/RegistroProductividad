<?php

class LibrosController extends AppController {
    public $name = 'Libros';
    public $components = array('Session');
    
    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow('add', 'login', 'logout');
    }
    
    public function index() {
        $this->Libro->recursive = -1;
        $conditions = array('Libro.user_id' => $this->Auth->user('id'));
        $libros = $this->Libro->find('all', array(
            'conditions' => $conditions 
        ));    
        $this->set('libros', $libros);
    }
    
    public function agregar() {
        if ($this->request->is('post')) {
            $this->Libro->create();
            $this->request->data['Libro']['user_id'] = $this->Auth->user('id');
            if ($this->Libro->save($this->request->data)) {
                $this->success('Se ha registrado el artículo satisfactoriamente.');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    public function ver($id = null) {
        $this->Libro->id = $id;
        if (!$this->Libro->exists()) {
            throw new NotFoundException('Libro que buscas no existe.');
        } else {
            $this->Libro->recursive = -1;
            $libro = $this->Libro->read(null, $id);
            $this->set('libro', $libro);
        }
    }
    
    public function editar($id = null) {
        $this->Libro->id = $id;
        if (!$this->Libro->exists()) {
            throw new NotFoundException('Libro no existe.');
        }
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
            //$this->request->data['Libro']['id'] = $id;
        }
    }
}
?>
