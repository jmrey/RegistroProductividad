<?php
App::uses('AuthComponent', 'Controller/Component');

/**
 * Modelo de User 
 */
class User extends AppModel {
    /**
     * Nombre de Modelo
     * @var String 
     */
    public $name = 'User';
    /**
     * Nombre de la Tabla en la Base de Datos que utilizará el modelo.
     * @var String 
     */
    public $useTable = 'usuarios';
    
    /**
     * Condiciones que validarán los datos del Usuario.
     * @var array 
     */
    public $validate = array(
        'username' => array(
            'validateUsername' => array(
                'rule' => array('alphaNumeric'),
                'required' => true,
                'message' => 'Nombre usuario debe contener sólo letras y números.'
            ),
            'uniqueUsername' => array(
                'rule' => 'isUnique',
                'message' => 'El nombre de usuario no está disponible.'
            ),
            'between' => array(
                'rule' => array('between', 3, 15),
                'message' => 'Entre 3 y 15 caracteres.'
            )
        ),
        'nombre' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'require' => true,
                'message' => 'Nombre Completo es requerido.'
            ),
            'validate' => array(
                'rule' => '/^[A-Za-zÁÉÍÓÚÑáéíóúñ ]+$/i',
                'message' => 'Caracteres no permitidos.'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('minLength', 6),
                'allowEmpty' => false,
                'required' => true,
                'message' => 'La contraseña debe tener 6 caracteres mínimo.'
            )
        ),
        'email' => array(
            'validateEmail' => array(
                'rule' => 'email',
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Por favor ingresa un email válido.'
            ),
            'uniqueEmail' => array(
                'rule' => 'isUnique',
                'message' => 'Ya ha sido registrado esta cuenta de correo.'
            )
        ),
        'escuela' => array(
            'isNumber' => array(
                'rule' => 'numeric',
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Por favor, elige una escuela.'
            )
        ),
        'depto' => array(
            'isNumber' => array(
                'rule' => 'numeric',
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Por favor, elige un departamento.'
            )
        ),
        'no_empleado' => array(
            'validateNumEmpleado' => array(
                'rule' => 'numeric',
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Por favor ingresa un Núm. de Empleado válido.'
            ),
            'between' => array(
                'rule' => array('between', 7, 7),
                'message' => 'Deben ser 7 caracteres númericos.'
            ),
            'uniqueNumEmpleado' => array(
                'rule' => 'isUnique',
                'message' => 'Ya ha sido registrado este Núm. de Empleado.'
            )
        )
    );
    
    /**
     * Método que se ejecuta antes de guardar los datos del usuario.
     * Aplica una función HASH al password del usuario para que no se guarde en texto plano.
     * @return boolean 
     */
    public function beforeSave() {
        if(isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }
}
?>
