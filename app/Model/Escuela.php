<?php
App::uses('AuthComponent', 'Controller/Component');

/**
 * Modelo de Escuela
 */
class Escuela extends AppModel {
    
    /**
     * Nombre de Modelo
     * @var String 
     */
    public $name = 'Escuela';
    
    /**
     * Nombre de la Tabla en la Base de Datos que utilizará el modelo.
     * @var String 
     */
    public $useTable = 'escuelas';
    
    /**
     * Array de validaciones de la Escuela.
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
            'uniqueName' => array(
                'rule' => 'isUnique',
                'message' => 'El nombre de la escuela ya ha sido registrado.'
            ),
        ),
        'acronimo' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'require' => true,
                'message' => 'Acronimo es requerido.'
            ),
            'validate' => array(
                'rule' => '/^[A-Za-z]+$/i',
                'message' => 'Sólo letras (A-Z).'
            ),
            'uniqueName' => array(
                'rule' => 'isUnique',
                'message' => 'Acrónimo ya existe.'
            ),
        )
    );
    
    /**
     * Lista todas las escuelas registradas en la Base de Datos.
     * @return array Lista de Escuelas 
     */
    public function listEscuelas() {
        return $this->find('list', array(
            'fields' => array('Escuela.id', 'Escuela.acronimo'),
            'order' => array('Escuela.acronimo ASC'),
            'recursive' => -1
        ));
    }
}
?>
