<?php
App::uses('AuthComponent', 'Controller/Component');

/**
 * Modelo de Artículo 
 */
class Articulo extends AppModel {
    /**
     * Nombre de Modelo
     * @var String 
     */
    public $name = 'Articulo';
    /**
     * Nombre de la Tabla en la Base de Datos que utilizará el modelo.
     * @var String 
     */
    public $useTable = 'articulos';
    
    /**
     * Array de validaciones del Artículo.
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
        'titulo_revista' => array(
            'validate' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Este campo es obligatorio.'
            )
        ),
        'tipo_articulo' => array(
            'validate' => array(
                'rule' => array('range', -1, 6),
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Ingresa una opción válida.'
            )
        ),
        'volumen' => array(
            'numeric' => array(
                'rule' => 'numeric',
                'allowEmpty' => true,
                'message' => 'Ingresa sólo números.'
            )
        ),
        'num_volumen' => array(
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
     * Busca un Artículo del usuario en base a un patrón.
     * @param String $query Patrón de búsqueda.
     * @param Integer $id Identificador de Usuario
     * @return Array Array que contiene al Artículo encontrado.
     */
    public function findByQuery($query = '', $id = null) {
        $conditions = array(
            'OR' => array(
                array('Articulo.titulo LIKE' => '%' . $query .'%'),
                array('Articulo.titulo_revista LIKE' => '%' . $query .'%')
            ),
            'AND' => array(
                array('Articulo.user_id' => $id)
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
                array('Articulo.titulo LIKE' => '%' . $query .'%'),
                array('Articulo.titulo_revista LIKE' => '%' . $query .'%')
            ),
            'AND' => array(
                array('Articulo.user_id' => $id)
            ));
        return $conditions;
    }
}
?>
