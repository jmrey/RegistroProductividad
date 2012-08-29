<?php

/**
 * Controlador de derechos de autor.
 * @class DerechosController 
 */
class DerechosController extends AppController {
    /**
     * Nombre del Controlador.
     * @var String
     */
    public $name = 'Derechos';
    /**
     * Componentes necesarios que utiliza el Controlador.
     * @var Array 
     */
    public $components = array('Session');
    
    /**
     * Opciones para la paginación de los derechos de autor.
     * @var Array 
     */
    public $paginate = array(
        'limit' => 20,
        'order' => array(
            'Derecho.fecha_presentacion' => 'asc',
            'Derecho.titulo' => 'asc'
        )
    );
    
    /**
     * Función llamada antes de ejecutar cualquier acción del controlador. 
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('title_for_layout', $this->name . ' de Autor');
        $this->Auth->allow('json_index');
    }
    
    /**
     * index(): Recupera todos los derechos de autor asociados al usuario que ha iniciado sesión.
     */
    public function index() {
        $this->Derecho->recursive = -1;
        $this->paginate['conditions'] = array('Derecho.user_id' => $this->Auth->user('id'));
        $derechos = $this->paginate();
        $this->set('derechos', $derechos);
    }
    
    /**
     * admin_index(): Recupera todos los derechos de autor que existen en la Base de Datos. 
     */
    public function admin_index() {
        $this->Derecho->recursive = -1;
        $this->set('derechos', $this->paginate());
    }
    
    /**
     * json_index(): Busca los derechos de autor en base a un campo y un patrón.
     * Los resultados son mostrados en formato JSON.
     * @param String $field
     * @param String $query 
     */
    public function json_index($field = null, $query = null) {
        $this->autoRender = false;
        $conditions = array(
            'conditions' => array('Derecho.' . $field . ' LIKE' => '%' . $query .'%'),
            'fields' => 'DISTINCT Derecho.' . $field,
            'order' => 'Derecho.' . $field,
        );
        
        $results = $this->Derecho->find('all', $conditions);
        $json_array = array();
        foreach ($results as $key => $value) {
            array_push($json_array, $value['Derecho'][$field]);
        }
        echo json_encode($json_array);
    }
    
    /**
     * nuevo(): Crea un nuevo Derecho de Autor. 
     */
    public function nuevo() {
        if ($this->request->is('post')) {
            $this->Derecho->create();
            $this->request->data['Derecho']['user_id'] = $this->Auth->user('id');
            if ($this->Derecho->save($this->request->data)) {
                $this->success('Se ha registrado el derecho de autor satisfactoriamente.');
                $this->redirect('/derechos/' . $this->Derecho->id . '/archivos');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    /**
     * ver(): Muestra un artículo con el ID = $id.
     * @param Integer $id Identificador del Derecho de Autor
     * @throws NotFoundException Si no encuentra aun artículo con el respectivo ID.
     */
    public function ver($id = null) {
        $this->Derecho->id = isset($id) ? $id : $this->request->params['id'];
        if (!$this->Derecho->exists()) {
            throw new NotFoundException('Derecho que buscas no existe.');
        } else {
            $this->Derecho->recursive = -1;
            $derecho = $this->Derecho->read(null, $id);
            $this->set('derecho', $derecho);
        }
    }
    
    /**
     * editar(): Obtiene el artículo con el ID = $id y muestra la vista para editarlo.
     * @param Integer $id
     * @throws NotFoundException Si no encuentra aun artículo con el respectivo ID.
     */
    public function editar($id = null) {
        $this->Derecho->id = $id;
        if (!$this->Derecho->exists()) {
            throw new NotFoundException('Derecho no existe.');
        }
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Derecho->save($this->request->data)) {
                $this->request->data['Derecho']['id'] = $id;
                $this->success('Se han actualizado los datos.');
            } else {
                $this->error('No se han podido guardar los datos.');
            }
        } else {
            $this->Derecho->recursive = -1;
            $this->request->data = $this->Derecho->read(null, $id);
        }
    }
    
    /**
     * Borra un artículo con ID = $id, verificando si el usuario posee permisos para borrar el artículo.
     * @param Integer $id Identificador de Derecho de Autor.
     * @throws MethodNotAllowedException Si el método de la petición no es POST o DELETE
     * @throws NotFoundException Si no encuentra aun artículo con el respectivo ID.
     */
    public function borrar($id = null) {
        $this->autoRender = false;
        
        if (!($this->request->is('post') || $this->request->is('delete'))) {
            throw new MethodNotAllowedException();
        }
        $this->Derecho->id = $id;
        if (!$this->Derecho->exists()) {
            throw new NotFoundException('Derecho no existe o ya ha sido borrado.');
        }
        
        $isOwnedBy = $this->Derecho->isOwnedBy($id, $this->Auth->user('id'));
        if ($isOwnedBy) {
            if ($this->Derecho->delete()) {
                $this->success('La derecho ha sido borrado.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->error('La derecho no se ha podido borrar.');
            }
        } else {
            $this->error('No tienes los permisos para esta acción.');
            $this->redirect(array('action' => 'index'));
        }
        //$this->redirect(array('action' => 'index'));
    }
    
    /**
     * search(): Busca un artículo en base a un patrón. 
     */
    public function search() {
        $query = $this->params['url']['q'];
        if (!$query) {
            $this->set('derechos', array());
        } else {
            $this->set('derechos', $this->Derecho->findByQuery($query, $this->Auth->user('id')));
        }
    }
    
    /**
     * Obtiene los derechos de autor del usuario que ha iniciado sesión.
     * @param String $type Formato en que exportará los derechos de autor (XML, PDF, TXT).  
     */
    public function exportar($type = null) {
        $this->Derecho->recursive = -1;
        $results = $this->Derecho->findAllByUserId($this->Auth->user('id'));
        $this->_exportar($results, $type);
    }
    
    /**
     * Obtiene todos los derechos de autor de la base de Datos y los exporta a un archivo (XML, PDF, TXT).
     * @param String $type Formato en que exportará los derechos de autor(XML, PDF, TXT). 
     */
    public function admin_exportar($type = null) {
        $this->Derecho->recursive = -1;
        $results = $this->Derecho->find('all');
        $this->_exportar($results, $type);
    }
}
?>
