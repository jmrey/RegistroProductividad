<?php
App::uses('AuthComponent', 'Controller/Component');
/**
 * Modelo de Curso 
 */
class Curso extends AppModel {
    /**
     * Nombre de Modelo
     * @var String 
     */
    public $name = 'Curso';
    /**
     * Nombre de la Tabla en la Base de Datos que utilizará el modelo.
     * @var String 
     */
    public $useTable = 'cursos';
    
    /**
     * Tipo de Cursos
     * @var array 
     */
    public $tipoCurso = array( 
        'licenciatura' => 'Licenciatura',
        'maestria' => 'Maestría',
        'especialidad' => 'Especialidad',
        'doctorado' => 'Doctorado'
    );
    
    /**
     * Array de validaciones del Curso.
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
        'tipo_curso' => array(
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
     * Busca un Curso del usuario en base a un patrón.
     * @param String $query Patrón de búsqueda.
     * @param Integer $id Identificador de Usuario
     * @return Array Array que contiene al Curso encontrado.
     */
    public function findByQuery($query = '', $id = null) {
        $conditions = array(
            'OR' => array(
                array('Curso.nombre LIKE' => '%' . $query .'%'),
                array('Curso.lista_autores LIKE' => '%' . $query .'%')
            ),
            'AND' => array(
                array('Curso.user_id' => $id)
            ));
        $this->recursive = -1;
        return $this->find('all', array('conditions' => $conditions));
    }
}
?>
