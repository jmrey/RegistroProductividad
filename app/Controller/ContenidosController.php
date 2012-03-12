<?php

class ContenidosController extends AppController {
    public $name = 'Contenidos';
    public $components = array('Session');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('display');
    }
    
    public function add() {
        if ($this->request->is('post')) {
            $this->Setting->create();
            if ($this->Setting->save($this->request->data)) {
                $this->success('La configuración se ha guardado satisfactoriamente.');
            } else {
                $this->warning('Ha ocurrido un problema.');
            }
        }
    }
    
    public function display($name = null) {
        $conditions = array('Contenido.name' => $name);
        $contenido = $this->Contenido->find('first', array(
            'conditions' => $conditions
        ));
        $this->set('contenido', $contenido);
    }
    
    public function editar($id = null) {
        $this->Contenido->id = $id;
        if (!$this->Contenido->exists()) {
            throw new NotFoundException('Contenido no existe.');
        }
        
        $this->Contenido->recursive = -1;
        $contenido = $this->Contenido->read(null, $id);
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Contenido->save($this->request->data)) {
                $this->success('Se han actualizado los datos.');
            } else {
                $this->error('No se han podido guardar los datos.');
            }
        } else {
            $this->request->data = $contenido;
        }
    }
}
?>
