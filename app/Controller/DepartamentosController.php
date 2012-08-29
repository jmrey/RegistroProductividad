<?php

App::uses('CakeEmail', 'Network/Email');

/**
 * Controlador de Departamentos.
 * @class DepartamentosController 
 */
class DepartamentosController extends AppController {
    /**
     * Nombre del Controlador.
     * @var String
     */
    public $name = 'Departamentos';
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
        $this->Auth->allow(array('json_get'));
    }
    
    /**
     * admin_index(): Recupera todos los departamentos que existen en la Base de Datos. 
     */
    public function admin_index() {
        $this->Departamento->recursive = 0;
        $this->set('deptos', $this->paginate());
    }
    
    /**
     * json_get(): Obtiene una lista de los departamentos asociados a una escuela.
     * Los resultados son mostrados en formato JSON.
     * @param String $field
     * @param String $query 
     */
    public function json_get($field = null, $query = null) {
        $this->autoRender = false;
        $field = ($field === 'escuela') ? 'escuela_id' : $field; 
        $conditions = array(
            'conditions' => array('Departamento.' . $field => $query),
            'fields' => array('Departamento.id', 'Departamento.nombre'),
            'order' => 'Departamento.nombre ASC',
            'recursive' => -1
        );
        
        $results = $this->Departamento->find('list', $conditions);
        //debug($results); die;
        echo json_encode($results);
    }
    
    /**
     * admin_nuevo(): Permite al administrador crea una nuevo Departamento. 
     */
    public function admin_nuevo() {
        $this->loadModel('Escuela');
        if ($this->request->is('post')) {
            $this->Departamento->create();
            if ($this->Departamento->save($this->request->data)) {
                $this->success('Se ha agregado la Departamento satifactoriamente.');
                $this->redirect(array('admin' => 1, 'controller' => 'Departamentos', 'action' => 'index'));
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
        $this->set('escuelas', $this->Escuela->listEscuelas());
    }
}
?>
