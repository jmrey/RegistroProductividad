<?php
App::uses('AuthComponent', 'Controller/Component');

class Libro extends AppModel {
    public $name = 'Libro';
    public $useTable = 'libros';
    
    public $tipoLibros = array( 
        '0' => 'Autorizado',
        '1' => 'Compilación',
        '2' => 'Editado',
        '3' => 'Publicado',
        '4' => 'Traducido'
    );
    
    public $validate = array(
        'isbn' => array(
            'validateISBN' => array(
                'rule' => '/^(97[89][- ]){0,1}[0-9]{1,5}[- ][0-9]{1,7}[- ][0-9]{1,6}[- ][0-9Xx]$/i',
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Ingresa un ISBN válido.'
            )
        ),
        'titulo' => array(
            'validate' => array(
                'rule' => 'notEmpty',
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Este campo es obligatorio.'
            )
        ),
        'tipo_libro' => array(
            'validateTipoLibro' => array(
                'rule' => array('range', -1, 5),
                'allowEmpty' => false,
                'required' => true,
                'message' => 'Ingresa una opción válida.'
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
        'edicion' => array(
            'validateEdicion' => array(
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
        'volumen' => array(
            'numeric' => array(
                'rule' => 'numeric',
                'allowEmpty' => true,
                'message' => 'Ingresa sólo números.'
            )
        ),
        'palabra_clave1' => array(
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
                array('Libro.titulo LIKE' => '%' . $query .'%'),
                array('Libro.editorial LIKE' => '%' . $query .'%')
            ),
            'AND' => array(
                array('Libro.user_id' => $id)
            ));
        $this->recursive = -1;
        return $this->find('all', array('conditions' => $conditions));
    }
}
?>
