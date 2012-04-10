<?php

class DashboardController extends AppController {
    var $name = 'Dashboard';
    var $uses =array();
    
    public function index() {
        
    }
    
    public function admin_index() {
        if (!parent::isAdmin()) {
            $this->redirect('/dashboard');
        }
    }
    
    public function admin_config() {
        if (!parent::isAdmin()) {
            $this->redirect('/dashboard');
        }
        $this->loadModel('Contenido');
        $this->set($this->Contenido->getProperties());
    }
}
?>
