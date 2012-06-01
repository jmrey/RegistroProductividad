<?php

App::uses('CakeEmail', 'Network/Email');

class EscuelasController extends AppController {
    public $name = 'Escuelas';
    public $components = array('Session');
    //public $uses = array('User', 'Contenido');
    
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    public function admin_index() {
        $this->Escuela->recursive = -1;
        $this->set('escuelas', $this->paginate());
    }
    
    public function admin_nuevo() {
        if ($this->request->is('post')) {
            $this->Escuela->create();
            if ($this->Escuela->save($this->request->data)) {
                $this->success('Se ha agregado la escuela satifactoriamente.');
                $this->redirect(array('admin' => 1, 'controller' => 'escuelas', 'action' => 'index'));
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
}
?>
