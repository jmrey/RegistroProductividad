<?php
App::uses('AuthComponent', 'Controller/Component');

class Patente extends AppModel {
    public $name = 'Patente';
    public $useTable = 'patentes';
    
    public $estadoPatentes = array(
        '0' => 'En trámite',
        '1' => 'En explotación comercial',
        '2' => 'Registrada'
    );
    
    public $tipoPatentes = array(
        '0' => 'Diseño Industrial',
        '1' => 'Modelo de Utilidad',
        '2' => 'Patente'
    );
    
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
