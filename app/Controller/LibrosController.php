<?php

/**
 * Controlador de Libros.
 * @class LibrosController 
 */
class LibrosController extends AppController {
    /**
     * Nombre del Controlador.
     * @var String
     */
    public $name = 'Libros';
    /**
     * Componentes necesarios que utiliza el Controlador.
     * @var Array 
     */
    public $components = array('Session');
    
    /**
     * Opciones para la paginación de los Libros.
     * @var Array 
     */
    public $paginate = array(
        'limit' => 20,
        'order' => array(
            'Libro.anio_publicacion' => 'asc',
            'Libro.titulo' => 'asc'
        )
    );
    
    /**
     * Función llamada antes de ejecutar cualquier acción del controlador. 
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('json_index');
    }
    
    /**
     * index(): Recupera todos los libros asociados al usuario que ha iniciado sesión.
     */
    public function index() {
        $this->paginate['conditions'] = array('Libro.user_id' => $this->Auth->user('id'));
        $this->Libro->recursive = -1;
        $libros = $this->paginate();
        $this->set('tipo_libros', $this->Libro->tipoLibros);
        $this->set('libros', $libros);
    }
    
    /**
     * admin_index(): Recupera todos los libros que existen en la Base de Datos. 
     */
    public function admin_index() {
        $this->Libro->recursive = -1;
        $this->set('tipo_libros', $this->Libro->tipoLibros);
        $this->set('libros', $this->paginate());
    }
    
    /**
     * json_index(): Busca los libros en base a un campo y un patrón.
     * Los resultados son mostrados en formato JSON.
     * @param String $field
     * @param String $query 
     */
    public function json_index($field = null, $query = null) {
        $this->autoRender = false;
        $conditions = array(
            'conditions' => array('Libro.' . $field . ' LIKE' => '%' . $query .'%'),
            'fields' => 'DISTINCT Libro.' . $field,
            'order' => 'Libro.' . $field,
        );
        
        $results = $this->Libro->find('all', $conditions);
        $json_array = array();
        foreach ($results as $key => $value) {
            array_push($json_array, $value['Libro'][$field]);
        }
        echo json_encode($json_array);
    }
    
    /**
     * nuevo(): Crea un nuevo Libro. 
     */
    public function nuevo() {
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        $this->set('tipo_libros', $this->Libro->tipoLibros);
        if ($this->request->is('post')) {
            $this->Libro->create();
            $this->request->data['Libro']['user_id'] = $this->Auth->user('id');
            if ($this->Libro->save($this->request->data)) {
                $this->success('Se ha registrado el libro satisfactoriamente.');
                $this->redirect('/libros/' . $this->Libro->id . '/archivos');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    /**
     * ver(): Muestra un libro con el ID = $id.
     * @param Integer $id Identificador del Libro
     * @throws NotFoundException Si no encuentra al libro con el respectivo ID.
     */
    public function ver($id = null) {
        $this->Libro->id = isset($id) ? $id : $this->request->params['id'];
        if (!$this->Libro->exists()) {
            throw new NotFoundException('Libro que buscas no existe.');
        } else {
            $this->Libro->recursive = -1;
            $libro = $this->Libro->read(null, $id);
            $this->set('libro', $libro);
        }
    }
    
    /**
     * editar(): Obtiene el libro con el ID = $id y muestra la vista para editarlo.
     * @param Integer $id
     * @throws NotFoundException Si no encuentra al libro con el respectivo ID.
     */
    public function editar($id = null) {
        $this->Libro->id = $id;
        if (!$this->Libro->exists()) {
            throw new NotFoundException('Libro no existe.');
        }
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        $this->set('tipo_libros', $this->Libro->tipoLibros);
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Libro']['id'] = $id;
            if ($this->Libro->save($this->request->data)) {
                $this->success('Se han actualizado los datos.');
            } else {
                $this->error('No se han podido guardar los datos.');
            }
        } else {
            $this->Libro->recursive = -1;
            $this->request->data = $this->Libro->read(null, $id);
        }
    }
    
    /**
     * Borra un libro con ID = $id, verificando si el usuario posee permisos para borrar el libro.
     * @param Integer $id Identificador de Libro.
     * @throws MethodNotAllowedException Si el método de la petición no es POST o DELETE
     * @throws NotFoundException Si no encuentra al libro con el respectivo ID.
     */
    public function borrar($id = null) {
        $this->autoRender = false;
        
        if (!($this->request->is('post') || $this->request->is('delete'))) {
            throw new MethodNotAllowedException();
        }
        $this->Libro->id = $id;
        if (!$this->Libro->exists()) {
            throw new NotFoundException('Libro no existe o ya ha sido borrado.');
        }
        
        $isOwnedBy = $this->Libro->isOwnedBy($id, $this->Auth->user('id'));
        if ($isOwnedBy) {
            if ($this->Libro->delete()) {
                $this->success('El libro ha sido borrado.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->error('El libro no se ha podido borrar.');
            }
        } else {
            $this->error('No tienes los permisos para está acción.');
            $this->redirect(array('action' => 'index'));
        }
        //$this->redirect(array('action' => 'index'));
    }
    
    /**
     * search(): Busca un libro en base a un patrón. 
     */
    public function search() {
        $query = $this->params['url']['q'];
        if (!$query) {
            $this->set('libros', array());
        } else {
            $this->set('libros', $this->Libro->findByQuery($query, $this->Auth->user('id')));
        }
        $this->set('tipo_libros', $this->Libro->tipoLibros);
    }
    
    /**
     * Obtiene los libros del usuario que ha iniciado sesión.
     * @param String $type Formato en que exportará los libros (XML, PDF, TXT).  
     */
    public function exportar($type = null) {
        $this->Libro->recursive = -1;
        $results = $this->Libro->findAllByUserId($this->Auth->user('id'));
        $this->set('tipo_libros', $this->Libro->tipoLibros);
        $this->_exportar($results, $type);
    }
    
    /**
     * Obtiene todos los libros de la base de Datos y los exporta a un archivo (XML, PDF, TXT).
     * @param String $type Formato en que exportará los libros(XML, PDF, TXT). 
     */
    public function admin_exportar($type = null) {
        $this->Articulo->recursive = -1;
        $results = $this->Libro->find('all');
        $this->_exportar($results, $type);
    }
}
?>
