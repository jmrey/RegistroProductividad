<?php

/**
 * Controlador de Congresos.
 * @class CongresosController 
 */
class CongresosController extends AppController {
    /**
     * Nombre del Controlador.
     * @var String
     */
    public $name = 'Congresos';
    
    /**
     * Componentes necesarios que utiliza el Controlador.
     * @var Array 
     */
    public $components = array('Session');
    
    /**
     * Opciones para la paginación de los Congresos.
     * @var Array 
     */
    public $paginate = array(
        'limit' => 20,
        'order' => array(
            'Congreso.anio_publicacion' => 'asc',
            'Congreso.nombre' => 'asc'
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
     * index(): Recupera todos los artículos asociados al usuario que ha iniciado sesión.
     */
    public function index() {
        $this->Congreso->recursive = -1;
        $this->paginate['conditions'] = array('Congreso.user_id' => $this->Auth->user('id'));
        $congresos = $this->paginate();
        $this->set('tipo_congreso', $this->Congreso->tipoCongreso);
        $this->set('congresos', $congresos);
    }
    
    /**
     * admin_index(): Recupera todos los artículos que existen en la Base de Datos. 
     */
    public function admin_index() {
        $this->Congreso->recursive = -1;
        $this->set('tipo_congreso', $this->Congreso->tipoCongreso);
        $this->set('congresos', $this->paginate());
    }
    
    /**
     * json_index(): Busca los congresos en base a un campo y un patrón.
     * Los resultados son mostrados en formato JSON.
     * @param String $field
     * @param String $query 
     */
    public function json_index($field = null, $query = null) {
        $this->autoRender = false;
        $conditions = array(
            'conditions' => array('Congreso.' . $field . ' LIKE' => '%' . $query .'%'),
            'fields' => 'DISTINCT Congreso.' . $field,
            'order' => 'Congreso.' . $field,
        );
        
        $results = $this->Congreso->find('all', $conditions);
        $json_array = array();
        foreach ($results as $key => $value) {
            array_push($json_array, $value['Congreso'][$field]);
        }
        echo json_encode($json_array);
    }
    
    /**
     * nuevo(): Crea un nuevo Congreso. 
     */
    public function nuevo() {
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        $this->set('tipo_congreso', $this->Congreso->tipoCongreso);
        if ($this->request->is('post')) {
            $this->Congreso->create();
            $this->request->data['Congreso']['user_id'] = $this->Auth->user('id');
            if ($this->Congreso->save($this->request->data)) {
                $this->success('Se ha registrado el congreso satisfactoriamente.');
                $this->redirect('/congresos/' . $this->Congreso->id . '/archivos');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    /**
     * ver(): Muestra un artículo con el ID = $id.
     * @param Integer $id Identificador del Congreso
     * @throws NotFoundException Si no encuentra aun artículo con el respectivo ID.
     */
    public function ver($id = null) {
        $this->Congreso->id = isset($id) ? $id : $this->request->params['id'];
        if (!$this->Congreso->exists()) {
            throw new NotFoundException('Congreso que buscas no existe.');
        } else {
            $this->Congreso->recursive = -1;
            $congreso = $this->Congreso->read(null, $id);
            $this->set('tipo_congreso', $this->Congreso->tipoCongreso);
            $this->set('congreso', $congreso);
        }
    }
    
    /**
     * editar(): Obtiene el artículo con el ID = $id y muestra la vista para editarlo.
     * @param Integer $id
     * @throws NotFoundException Si no encuentra aun artículo con el respectivo ID.
     */
    public function editar($id = null) {
        $this->Congreso->id = $id;
        if (!$this->Congreso->exists()) {
            throw new NotFoundException('Congreso no existe.');
        }
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        $this->set('tipo_congreso', $this->Congreso->tipoCongreso);
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Congreso->save($this->request->data)) {
                $this->request->data['Congreso']['id'] = $id;
                $this->success('Se han actualizado los datos.');
            } else {
                $this->error('No se han podido guardar los datos.');
            }
        } else {
            $this->Congreso->recursive = -1;
            $this->request->data = $this->Congreso->read(null, $id);
        }
    }
    
    /**
     * Borra un artículo con ID = $id, verificando si el usuario posee permisos para borrar el artículo.
     * @param Integer $id Identificador de Congreso.
     * @throws MethodNotAllowedException Si el método de la petición no es POST o DELETE
     * @throws NotFoundException Si no encuentra aun artículo con el respectivo ID.
     */
    public function borrar($id = null) {
        $this->autoRender = false;
        
        if (!($this->request->is('post') || $this->request->is('delete'))) {
            throw new MethodNotAllowedException();
        }
        $this->Congreso->id = $id;
        if (!$this->Congreso->exists()) {
            throw new NotFoundException('Congreso no existe o ya ha sido borrado.');
        }
        
        $isOwnedBy = $this->Congreso->isOwnedBy($id, $this->Auth->user('id'));
        if ($isOwnedBy) {
            if ($this->Congreso->delete()) {
                $this->success('El Congreso ha sido borrado.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->error('El Congreso no se ha podido borrar.');
            }
        } else {
            $this->error('No tienes los permisos para está acción.');
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
            $this->set('congresos', array());
        } else {
            $this->set('congresos', $this->Congreso->findByQuery($query, $this->Auth->user('id')));
        }
        $this->set('tipo_congreso', $this->Congreso->tipoCongreso);
    }
    
    /**
     * Obtiene los artículos del usuario que ha iniciado sesión.
     * @param String $type Formato en que exportará los artículos (XML, PDF, TXT).  
     */
    public function exportar($type = null) {
        $this->Congreso->recursive = -1;
        $results = $this->Congreso->findAllByUserId($this->Auth->user('id'));
        $this->set('tipo_congreso', $this->Congreso->tipoCongreso);
        $this->_exportar($results, $type);
    }
    
    /**
     * Obtiene todos los artículos de la base de Datos y los exporta a un archivo (XML, PDF, TXT).
     * @param String $type Formato en que exportará los artículos(XML, PDF, TXT). 
     */
    public function admin_exportar($type = null) {
        $this->Congreso->recursive = -1;
        $results = $this->Congreso->find('all');
        $this->_exportar($results, $type);
    }
}
?>
