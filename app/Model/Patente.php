<?php
App::uses('AuthComponent', 'Controller/Component');

/**
 * Modelo de Patente 
 */
class Patente extends AppModel {
    /**
     * Nombre de Modelo
     * @var String 
     */
    public $name = 'Patente';
    
    /**
     * Nombre de la Tabla en la Base de Datos que utilizará el modelo.
     * @var String 
     */
    public $useTable = 'patentes';
    
    /**
     * Estado de las Patentes
     * @var array 
     */
    public $estadoPatentes = array(
        '0' => 'En trámite',
        '1' => 'En explotación comercial',
        '2' => 'Registrada'
    );
    
    /**
     * Tipo de las Patentes
     * @var array 
     */
    public $tipoPatentes = array(
        '0' => 'Diseño Industrial',
        '1' => 'Modelo de Utilidad',
        '2' => 'Patente'
    );
    
    /**
     * Array de validaciones de Patente.
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
     * Busca una Patente del usuario en base a un patrón.
     * @param string $query Patrón de búsqueda.
     * @param integer $id Identificador de Usuario
     * @return array Array que contiene a la patente encontrada.
     */
    public function findByQuery($query = '', $id = null) {
        $conditions = array(
            'OR' => array(
                array('Patente.titulo LIKE' => '%' . $query .'%'),
                array('Patente.titular LIKE' => '%' . $query .'%')
            ),
            'AND' => array(
                array('Patente.user_id' => $id)
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
                array('Patente.titulo LIKE' => '%' . $query .'%'),
                array('Patente.titular LIKE' => '%' . $query .'%')
            ),
            'AND' => array(
                array('Patente.user_id' => $id)
            ));
        return $conditions;
    }
}
?>
