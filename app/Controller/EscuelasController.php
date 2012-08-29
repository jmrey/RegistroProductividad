<?php

App::uses('CakeEmail', 'Network/Email');

/**
 * Controlador de Escuelas
 * @lcass EscuelasController 
 */
class EscuelasController extends AppController {
    /**
     * Nombre del Controlador.
     * @var String
     */
    public $name = 'Escuelas';
    /**
     * Componentes necesarios que utiliza el Controlador.
     * @var Array 
     */
    public $components = array('Session');
    
    /**
     * Función llamada antes de ejecutar cualquier acción del controlador. 
     */
    public function beforeFilter() {
        parent::beforeFilter();
    }
    
    /**
     * admin_index(): Recupera todos las Escuelas que existen en la Base de Datos. 
     */
    public function admin_index() {
        $this->Escuela->recursive = -1;
        $this->set('escuelas', $this->paginate());
    }
    
    /**
     * admin_nuevo(): Permite al administrador crear una nueva escuela. 
     */
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
