<?php
App::uses('AuthComponent', 'Controller/Component');

class Escuela extends AppModel {
    public $name = 'Escuela';
    public $useTable = 'escuelas';
    
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
    
    public function listEscuelas() {
        return $this->find('list', array(
            'fields' => array('Escuela.id', 'Escuela.acronimo'),
            'order' => array('Escuela.acronimo ASC'),
            'recursive' => -1
        ));
    }
}
?>
