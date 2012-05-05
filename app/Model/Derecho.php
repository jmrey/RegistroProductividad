<?php
App::uses('AuthComponent', 'Controller/Component');

class Derecho extends AppModel {
    public $name = 'Derecho';
    public $useTable = 'derechos_autor';
    
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
