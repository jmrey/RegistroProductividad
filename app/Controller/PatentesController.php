<?php

/**
 * Controlador de Patentes.
 * @class PatentesController 
 */
class PatentesController extends AppController {
    /**
     * Nombre del Controlador.
     * @var String
     */
    public $name = 'Patentes';
    
    /**
     * Componentes necesarios que utiliza el Controlador.
     * @var Array 
     */
    public $components = array('Session');
    
    /**
     * Opciones para la paginación de las Patentes.
     * @var Array 
     */
    public $paginate = array(
        'limit' => 20,
        'order' => array(
            'Patente.fecha_presentacion' => 'asc',
            'Patente.titulo' => 'asc'
        )
    );
    
    /**
     * Método llamado antes de ejecutar cualquier acción del controlador. 
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('title_for_layout', $this->name);
        $this->set('estado_patentes', $this->Patente->estadoPatentes);
        $this->set('tipo_patentes', $this->Patente->tipoPatentes);
        $this->Auth->allow('json_index');
    }
    
    /**
     * index(): Recupera todas las patentes asociadas al usuario que ha iniciado sesión.
     */
    public function index() {
        $this->Patente->recursive = -1;
        $this->paginate['conditions'] = array('Patente.user_id' => $this->Auth->user('id'));
        $patentes = $this->paginate();
        $this->set('patentes', $patentes);
    }
    
    /**
     * admin_index(): Recupera todas las patentes que existen en la Base de Datos. 
     */
    public function admin_index() {
        $this->Patente->recursive = -1;
        $this->set('patentes', $this->paginate());
    }
    
    /**
     * json_index(): Busca las patentes en base a un campo y un patrón.
     * Los resultados son mostrados en formato JSON.
     * @param String $field
     * @param String $query 
     */
    public function json_index($field = null, $query = null) {
        $this->autoRender = false;
        $conditions = array(
            'conditions' => array('Patente.' . $field . ' LIKE' => '%' . $query .'%'),
            'fields' => 'DISTINCT Patente.' . $field,
            'order' => 'Patente.' . $field,
        );
        
        $results = $this->Patente->find('all', $conditions);
        $json_array = array();
        foreach ($results as $key => $value) {
            array_push($json_array, $value['Patente'][$field]);
        }
        echo json_encode($json_array);
    }
    
    /**
     * nuevo(): Crea una nueva patente. 
     */
    public function nuevo() {
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        if ($this->request->is('post')) {
            $this->Patente->create();
            $this->request->data['Patente']['user_id'] = $this->Auth->user('id');
            if ($this->Patente->save($this->request->data)) {
                $this->success('Se ha registrado el artículo satisfactoriamente.');
                $this->redirect('/patentes/' . $this->Patente->id . '/archivos');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    /**
     * ver(): Muestra la Patente con el ID = $id.
     * @param Integer $id Identificador de la Patente
     * @throws NotFoundException Si no encuentra a la Patente con el respectivo ID.
     */
    public function ver($id = null) {
        $this->Patente->id = isset($id) ? $id : $this->request->params['id'];
        if (!$this->Patente->exists()) {
            throw new NotFoundException('Patente que buscas no existe.');
        } else {
            $this->Patente->recursive = -1;
            $patente = $this->Patente->read(null, $id);
            $this->set('patente', $patente);
        }
    }
    
    /**
     * editar(): Obtiene la Patente con el ID = $id y muestra la vista para editarla.
     * @param Integer $id Identificador de la Patente
     * @throws NotFoundException Si no encuentra a la patente con el respectivo ID.
     */
    public function editar($id = null) {
        $this->Patente->id = $id;
        if (!$this->Patente->exists()) {
            throw new NotFoundException('Patente no existe.');
        }
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Patente->save($this->request->data)) {
                $this->request->data['Patente']['id'] = $id;
                $this->success('Se han actualizado los datos.');
            } else {
                $this->error('No se han podido guardar los datos.');
            }
        } else {
            $this->Patente->recursive = -1;
            $this->request->data = $this->Patente->read(null, $id);
        }
    }
    
    /**
     * Borra un artículo con ID = $id, verificando si el usuario posee permisos para borrar la patente.
     * @param Integer $id Identificador de Patente.
     * @throws MethodNotAllowedException Si el método de la petición no es POST o DELETE
     * @throws NotFoundException Si no encuentra a la Patente con el respectivo ID.
     */
    public function borrar($id = null) {
        $this->autoRender = false;
        
        if (!($this->request->is('post') || $this->request->is('delete'))) {
            throw new MethodNotAllowedException();
        }
        $this->Patente->id = $id;
        if (!$this->Patente->exists()) {
            throw new NotFoundException('Patente no existe o ya ha sido borrado.');
        }
        
        $isOwnedBy = $this->Patente->isOwnedBy($id, $this->Auth->user('id'));
        if ($isOwnedBy) {
            if ($this->Patente->delete()) {
                $this->success('La patente ha sido borrado.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->error('La patente no se ha podido borrar.');
            }
        } else {
            $this->error('No tienes los permisos para esta acción.');
            $this->redirect(array('action' => 'index'));
        }
        //$this->redirect(array('action' => 'index'));
    }
    
    /**
     * search(): Busca una patente en base a un patrón. 
     */
    public function search() {
        $query = $this->params['url']['q'];
        if (!$query) {
            $this->set('patentes', array());
        } else {
            $this->set('patentes', $this->Patente->findByQuery($query, $this->Auth->user('id')));
        }
    }
    
    /**
     * Obtiene las Patentes del usuario que ha iniciado sesión.
     * @param String $type Formato en que exportará las patentes (XML, PDF, TXT).  
     */
    public function exportar($type = null) {
        $this->Patente->recursive = -1;
        $results = $this->Patente->findAllByUserId($this->Auth->user('id'));
        $this->_exportar($results, $type);
    }
    
    /**
     * Obtiene todos las patentes de la base de Datos y los exporta a un archivo (XML, PDF, TXT).
     * @param String $type Formato en que exportará las patentes (XML, PDF, TXT). 
     */
    public function admin_exportar($type = null) {
        $this->Patente->recursive = -1;
        $results = $this->Patente->find('all');
        $this->_exportar($results, $type);
    }
}
?>
