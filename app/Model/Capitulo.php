<?php
App::uses('AuthComponent', 'Controller/Component');

/**
 * Modelo de Capítulo 
 */
class Capitulo extends AppModel {
    /**
     * Nombre de Modelo
     * @var String 
     */
    public $name = 'Capitulo';
    /**
     * Nombre de la Tabla en la Base de Datos que utilizará el modelo.
     * @var String 
     */
    public $useTable = 'capitulos';
    
    /**
     * Array de validaciones del Capítulo.
     * @var Array 
     */
    public $validate = array(
        'titulo_capitulo' => array(
            'validate' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Este campo es obligatorio.'
            )
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
                'message' => 'Ingresa un año válido.'
            )
        ),
        'titulo_libro' => array(
            'validate' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Este campo es obligatorio.'
            )
        ),
        'editores' => array(
            'validate' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Este campo es obligatorio.'
            )
        ),
        'editorial' => array(
            'validateEditorial' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Este campo es obligatorio.'
            )
        ),
        'volumen' => array(
            'numeric' => array(
                'rule' => 'numeric',
                'allowEmpty' => true,
                'message' => 'Ingresa sólo números.'
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
     * Busca un Capítulo del usuario en base a un patrón.
     * @param String $query Patrón de búsqueda.
     * @param Integer $id Identificador de Usuario
     * @return Array Array que contiene al Capítulo encontrado.
     */
    public function findByQuery($query = '', $id = null) {
        $conditions = array(
            'OR' => array(
                array('Capitulo.titulo_capitulo LIKE' => '%' . $query .'%'),
                array('Capitulo.titulo_libro LIKE' => '%' . $query .'%')
            ),
            'AND' => array(
                array('Capitulo.user_id' => $id)
            ));
        $this->recursive = -1;
        return $this->find('all', array('conditions' => $conditions));
    }
}
?>
