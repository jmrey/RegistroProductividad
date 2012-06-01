<?php
App::uses('AuthComponent', 'Controller/Component');

class Departamento extends AppModel {
    public $name = 'Departamento';
    public $useTable = 'departamentos';
    public $belongsTo = array(
        'Escuela' => array(
            'className'    => 'Escuela',
            'foreignKey'   => 'escuela_id'
        )
    );
    
    var $validate = array(
        'nombre' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'require' => true,
                'message' => 'Nombre es requerido.'
            ),
            'validate' => array(
                'rule' => '/^[A-Za-zÁÉÍÓÚÑáéíóúñ ]+$/i',
                'message' => 'Caracteres no permitidos.'
            ),
            'unique' => array(
                'rule' => 'existsInSchool',
                'message' => 'Departamento en esta Escuela ya existe.'
            )
        )
        
    );
    
    /*public function listDeptos($escuela_id = null) {
        return $this->find('list', array(
            'conditions' => array(
               'Departamento.escuela_id' => $escuela_id
           ),
            'fields' => array('Departamento.id', 'Departamento.nombre'),
            'order' => array('Departamento.nombre ASC'),
            'recursive' => -1
        ));
    }*/
    
    public function listDeptosFromEscuela($escuela_id = null) {
        return $this->find('list', array(
            'conditions' => array(
               'Departamento.escuela_id' => $escuela_id
           ),
            'fields' => array('Departamento.id', 'Departamento.nombre'),
            'order' => array('Departamento.nombre ASC'),
            'recursive' => -1
        ));
    }
    
    function existsInSchool($check) {
       $depto = $this->find('first', array(
           'conditions' => array(
               'Departamento.nombre' => $check['nombre'],
               'Departamento.escuela_id' => $this->data['Departamento']['escuela_id']
           ),
           'recursive' => -1
       ));
       //debug($depto); die;
       
       return (empty($depto));
    }
}
?>
