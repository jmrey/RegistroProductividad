<?php

App::uses('CakeEmail', 'Network/Email');

class DepartamentosController extends AppController {
    public $name = 'Departamentos';
    public $components = array('Session');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('json_get'));
    }
    
    public function admin_index() {
        $this->Departamento->recursive = 0;
        $this->set('deptos', $this->paginate());
    }
    
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
