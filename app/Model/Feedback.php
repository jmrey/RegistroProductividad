<?php
App::uses('AuthComponent', 'Controller/Component');

class Feedback extends AppModel {
    public $name = 'Feedback';
    public $useTable = false;
    
    var $_schema = array(
        'nombre'	=> array('type' => 'string', 'length' => 100), 
        'email'		=> array('type' => 'string', 'length' => 255), 
        'detalles'	=> array('type' => 'text')
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
            )
        ),
        'email' => array(
            'validateEmail' => array(
                'rule' => 'email',
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Por favor ingresa un email válido.'
            )
        ),
        'detalles' => array(
            'validate' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Este campo es obligatorio.'
            ),
            'between' => array(
                'rule' => array('between', 0, 500),
                'message' => 'Máximo 500 caracteres.'
            )
        )
    );
}
?>
