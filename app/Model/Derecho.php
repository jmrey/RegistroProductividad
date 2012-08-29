<?php
App::uses('AuthComponent', 'Controller/Component');

/**
 * Modelo de Derecho de Autor 
 */
class Derecho extends AppModel {
    /**
     * Nombre de Modelo
     * @var String 
     */
    public $name = 'Derecho';
    /**
     * Nombre de la Tabla en la Base de Datos que utilizará el modelo.
     * @var String 
     */
    public $useTable = 'derechos_autor';
    
    /**
     * Array de validaciones del Derecho de Autor.
     * @var Array 
     */
    public $validate = array(
        'titulo' => array(
            'validate' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Este campo es obligatorio.'
            )
        ),
        'numero_tramite' => array(
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
        'usuario' => array(
            'validate' => array(
                'rule' => '/^[A-Za-z ]+$/i',
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
     * Busca un Derecho de Autor del usuario en base a un patrón.
     * @param String $query Patrón de búsqueda.
     * @param Integer $id Identificador de Usuario
     * @return Array Array que contiene al Derecho de Autor encontrado.
     */
    public function findByQuery($query = '', $id = null) {
        $conditions = array(
            'OR' => array(
                array('Derecho.titulo LIKE' => '%' . $query .'%'),
                array('Derecho.usuario LIKE' => '%' . $query .'%')
            ),
            'AND' => array(
                array('Derecho.user_id' => $id)
            ));
        $this->recursive = -1;
        return $this->find('all', array('conditions' => $conditions));
    }
    
    /**
     * Genera condiciones de búsqueda.
     * @param String $query Patrón de búsqueda.
     * @param String $id Identificador de Usuario
     * @return array Retorna las condiciones de búsqueda.
     */
    public function queryConditions($query = '', $id = null) {
        $conditions = array(
            'OR' => array(
                array('Derecho.titulo LIKE' => '%' . $query .'%'),
                array('Derecho.titulo_revista LIKE' => '%' . $query .'%')
            ),
            'AND' => array(
                array('Derecho.user_id' => $id)
            ));
        return $conditions;
    }
}
?>
