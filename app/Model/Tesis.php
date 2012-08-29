<?php
App::uses('AuthComponent', 'Controller/Component');

/**
 * Modelo de Tesis 
 */
class Tesis extends AppModel {
    /**
     * Nombre de Modelo
     * @var String 
     */
    public $name = 'Tesis';
    
    /**
     * Nombre de la Tabla en la Base de Datos que utilizará el modelo.
     * @var String 
     */
    public $useTable = 'tesis';
    
    /**
     * Tipo de las Tesis
     * @var array 
     */
    public $tipoTesis = array( 
        'licenciatura' => 'Licenciatura',
        'maestria' => 'Maestría',
        'especialidad' => 'Especialidad',
        'doctorado' => 'Doctorado'
    );
    
    /**
     * Array de validaciones de Tesis.
     * @var Array 
     */
    public $validate = array(
        'nombre' => array(
            'validate' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Este campo es obligatorio.'
            )
        ),
        'num_autores' => array(
            'validate' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Este campo es obligatorio.'
            ),
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Ingresa sólo números.'
            )
        ),
        'pos_autor' => array(
            'validate' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Este campo es obligatorio.'
            ),
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Ingresa sólo números.'
            )
        ),
        'lista_autores' => array(
            'validate' => array(
                'rule' => '/^[A-Za-z, ]+$/i',
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Sólo letras, comas y espacios.'
            ),
        ),
        'lista_directores' => array(
            'validate' => array(
                'rule' => '/^[A-Za-z, ]+$/i',
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Sólo letras, comas y espacios.'
            ),
        ),
        'anio_publicacion' => array(
            'validate' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Este campo es obligatorio y debe contener sólo números.'
            ),
            'range' => array(
                'rule' => 'isYearInRange',
                //'rule' => array('range', 1949, 2013),
                'message' => 'Ingresa un año válido.'
            )
        ),
        'tipo_tesis' => array(
            'validate' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Este campo es obligatorio.'
            ),
            'allowedChoice' => array(
                'rule'    => array('inList', array('especialidad', 'doctorado', 'maestria', 'licenciatura')),
                'message' => 'Ingresa un tipo de tesis válido.'
            )
        ),
        'resumen' => array(
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
    
    /**
     * Busca una Tesis del usuario en base a un patrón.
     * @param string $query Patrón de búsqueda.
     * @param integer $id Identificador de Usuario
     * @return array Array que contiene a la Tesis encontrada.
     */
    public function findByQuery($query = '', $id = null) {
        $conditions = array(
            'OR' => array(
                array('Tesis.nombre LIKE' => '%' . $query .'%'),
                array('Tesis.lista_autores LIKE' => '%' . $query .'%')
            ),
            'AND' => array(
                array('Tesis.user_id' => $id)
            ));
        $this->recursive = -1;
        return $this->find('all', array('conditions' => $conditions));
    }
}
?>
