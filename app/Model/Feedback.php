<?php
App::uses('AuthComponent', 'Controller/Component');

/**
 * Modelo de Retroalimentación 
 */
class Feedback extends AppModel {
    /**
     * Nombre del Modelos
     * @var string 
     */
    public $name = 'Feedback';
    /**
     * Nombre de la Tabla en la Base de Datos que utilizará el modelo.
     * En este caso no se usará tabla.
     * @var string 
     */
    public $useTable = false;
    
    /**
     * Esquema asociado al Modelo.
     * @var array 
     */
    var $_schema = array(
        'nombre'	=> array('type' => 'string', 'length' => 100), 
        'email'		=> array('type' => 'string', 'length' => 255), 
        'detalles'	=> array('type' => 'text')
    );
    
    /**
     * Array de validaciones de Feedback.
     * @var array 
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
