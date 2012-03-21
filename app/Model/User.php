<?php
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {
    public $name = 'User';
    public $useTable = 'usuarios';
    public $deptosArray = array(
        '0' => 'Posgrado',
        '1' => 'Formación Básica',
        '2' => 'Ingeniería en Sistemas Computacionales',
        '3' => 'Ciencias e Ingenierías de la Computación',
        '4' => 'Formación Integral e Institucional'
    );
    
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
