<?php
App::uses('AuthComponent', 'Controller/Component');

/**
 * Modelo de Departamento 
 */
class Departamento extends AppModel {
    /**
     * Nombre de Modelo
     * @var String 
     */
    public $name = 'Departamento';
    /**
     * Nombre de la Tabla en la Base de Datos que utilizará el modelo.
     * @var String 
     */
    public $useTable = 'deptos';
    /**
     * Establece a que Modelo pertenece este Modelo.
     * @var array 
     */
    public $belongsTo = array(
        'Escuela' => array(
            'className'    => 'Escuela',
            'foreignKey'   => 'escuela_id'
        )
    );
    
    /**
     * Array de validaciones del Artículo.
     * @var Array 
     */
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
    
    /**
     * Lista los departamentos con el ID de escuela = $escuela_id
     * @param Intenger $escuela_id Identificador de Escuela
     * @return array Lista de Departamentos. 
     */
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
    
    /**
     * Verfica si existe un departamento en una Escuela.
     * @param type $check Datos a comparar.
     * @return bool 
     */
    function existsInSchool($check) {
       $depto = $this->find('first', array(
           'conditions' => array(
               'Departamento.nombre' => $check['nombre'],
               'Departamento.escuela_id' => $this->data['Departamento']['escuela_id']
           ),
           'recursive' => -1
       ));
       
       return (empty($depto));
    }
}
?>
