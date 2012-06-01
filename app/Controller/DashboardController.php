<?php

App::uses('ConnectionManager', 'Model');

class DashboardController extends AppController {
    var $name = 'Dashboard';
    var $uses =array();
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('feedback');
    }
    
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
    
    public function admin_smtp() {
        if (!parent::isAdmin()) {
            $this->redirect('/dashboard');
        }
        $this->loadModel('Contenido');
        $this->set($this->Contenido->getProperties());
    }
    
    public function admin_dbquery() {
        $db = &ConnectionManager::getDataSource('default');
        $db->query('ALTER TABLE  `usuarios` ADD  `escuela` INT UNSIGNED NOT NULL AFTER  `status`;');
        
    }
    
}
?>
