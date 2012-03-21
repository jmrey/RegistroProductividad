<?php

class ContenidosController extends AppController {
    public $name = 'Contenidos';
    public $components = array('Session');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('display');
    }
    
    public function display($name = null) {
        $contenido = $this->Contenido->findByName($name);
        if ($contenido == null) {
            throw new NotFoundException('Contenido no existe.');
        }
        $name = $contenido['Contenido']['name'];
        if ($name === 'inicio') {
            $this->set('titulo', $this->Contenido->getValue('titulo'));
        }
        $this->set('contenido', $contenido['Contenido']);
    }
    
    public function admin_add() {
        if (!parent::isAdmin()) {
            $this->redirect('/');
        }
        if ($this->request->is('post')) {
            $this->Contenido->create();
            if ($this->Contenido->save($this->request->data)) {
                $this->success('La configuración se ha guardado satisfactoriamente.');
            } else {
                $this->warning('Ha ocurrido un problema.');
            }
        }
    }
    
    public function admin_set($property = null, $value = null) {
        $this->autoRender = false;
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if (!parent::isAdmin()) {
            $this->redirect('/');
        }
        
        echo $this->Contenido->setProperty($property, $value) ? 'success': 'error';
    }
    
    public function admin_editar($name = null) {
        if (!parent::isAdmin()) {
            $this->redirect('/');
        }
        $contenido = $this->Contenido->findByName($name);
        if (empty($contenido)) {
            throw new NotFoundException('Contenido no existe.');
        }
        
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Contenido->save($this->request->data)) {
                $this->request->data['Contenido']['name'] = $name;
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
