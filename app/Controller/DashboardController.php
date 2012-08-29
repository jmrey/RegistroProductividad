<?php

App::uses('ConnectionManager', 'Model');
/**
 * Controlador del dasboard (Escritorio) dek usuario.
 * @class DashboardController
 * @extends AppController 
 */
class DashboardController extends AppController {
    /**
     * Nombre del Controlador
     * @var String 
     */
    var $name = 'Dashboard';
    
    /**
     * Inidica que modelos usará el controlador. Array vacío significa que no hace uso de ningún modelo. 
     * @var Array 
     */
    var $uses = array();
    
    /**
     * Función llamada antes de ejecutar cualquier acción del controlador. 
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('feedback');
    }
    
    /**
     * index(): Muestra el escritorio. 
     */
    public function index() {
    }
    
    /**
     * admin_index(): Muestra el escritorio del administrador. Verifica que el usuario sea administrador.
     */
    public function admin_index() {
        if (!parent::isAdmin()) {
            $this->redirect('/dashboard');
        }
    }
    
    /**
     * admin_config(): Muestra la vista de configuraciones de la aplicación al administrador.
     */
    public function admin_config() {
        if (!parent::isAdmin()) {
            $this->redirect('/dashboard');
        }
        $this->loadModel('Contenido');
        // Obetiene todas las propiedades de la aplicación.
        $this->set($this->Contenido->getProperties());
    }
    
    /**
     * admin_dbquery(): Permite al administrador ejecutar sentecias SQL. 
     */
    public function admin_dbquery() {
        $db = &ConnectionManager::getDataSource('default');
        $db->query('ALTER TABLE  `usuarios` ADD  `escuela` INT UNSIGNED NOT NULL AFTER  `status`;');
    }
    
}
?>
