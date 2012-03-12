<?php

class CapitulosController extends AppController {
    public $name = 'Capitulos';
    public $components = array('Session');
    
    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow('add', 'login', 'logout');
    }
    
    public function index() {
        $this->Capitulo->recursive = -1;
        $conditions = array('Capitulo.user_id' => $this->Auth->user('id'));
        $capitulos = $this->Capitulo->find('all', array(
            'conditions' => $conditions 
        ));    
        $this->set('capitulos', $capitulos);
    }
    
    public function agregar() {
        if ($this->request->is('post')) {
            $this->Capitulo->create();
            $this->request->data['Capitulo']['user_id'] = $this->Auth->user('id');
            if ($this->Capitulo->save($this->request->data)) {
                $this->success('Se ha registrado el artículo satisfactoriamente.');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    public function ver($id = null) {
        $this->Capitulo->id = $id;
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
}
?>
