<?php

/**
 * Controlador de Tesis.
 * @class TesisController 
 */
class TesisController extends AppController {
    /**
     * Nombre del Controlador.
     * @var String
     */
    public $name = 'Tesis';
    
    /**
     * Componentes necesarios que utiliza el Controlador.
     * @var Array 
     */
    public $components = array('Session');
    
    /**
     * Array de Modelos que usará el controlador.
     * @var Array
     */
    public $uses = array('Tesis');
    
    /**
     * Opciones para la paginación de las Tesis.
     * @var Array 
     */
    public $paginate = array(
        'limit' => 20,
        'order' => array(
            'Tesis.anio_publicacion' => 'asc',
            'Tesis.nombre' => 'asc'
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
     * index(): Recupera todas las Tesis asociados al usuario que ha iniciado sesión.
     */
    public function index() {
        $this->Tesis->recursive = -1;
        $this->paginate['conditions'] = array('Tesis.user_id' => $this->Auth->user('id'));
        $tesis = $this->paginate();
        $this->set('tipo_tesis', $this->Tesis->tipoTesis);
        $this->set('tesis', $tesis);
    }
    
    /**
     * admin_index(): Recupera todas las Tesis que existen en la Base de Datos. 
     */
    public function admin_index() {
        $this->Tesis->recursive = -1;
        $this->set('tipo_tesis', $this->Tesis->tipoTesis);
        $this->set('tesis', $this->paginate());
    }
    
    /**
     * json_index(): Busca las Tesis en base a un campo y un patrón.
     * Los resultados son mostrados en formato JSON.
     * @param String $field
     * @param String $query 
     */
    public function json_index($field = null, $query = null) {
        $this->autoRender = false;
        $conditions = array(
            'conditions' => array('Tesis.' . $field . ' LIKE' => '%' . $query .'%'),
            'fields' => 'DISTINCT Tesis.' . $field,
            'order' => 'Tesis.' . $field,
        );
        
        $results = $this->Tesis->find('all', $conditions);
        $json_array = array();
        foreach ($results as $key => $value) {
            array_push($json_array, $value['Tesis'][$field]);
        }
        echo json_encode($json_array);
    }
    
    /**
     * nuevo(): Crea una nueva Tesis. 
     */
    public function nuevo() {
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        $this->set('tipo_tesis', $this->Tesis->tipoTesis);
        if ($this->request->is('post')) {
            $this->Tesis->create();
            $this->request->data['Tesis']['user_id'] = $this->Auth->user('id');
            if ($this->Tesis->save($this->request->data)) {
                $this->success('Se ha registrado la tesis satisfactoriamente.');
                $this->redirect('/tesis/' . $this->Tesis->id . '/archivos');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    /**
     * ver(): Muestra la Tesis con el ID = $id.
     * @param Integer $id Identificador de Tesis
     * @throws NotFoundException Si no encuentra la Tesis con el respectivo ID.
     */
    public function ver($id = null) {
        $this->Tesis->id = isset($id) ? $id : $this->request->params['id'];
        if (!$this->Tesis->exists()) {
            throw new NotFoundException('Tesis que buscas no existe.');
        } else {
            $this->Tesis->recursive = -1;
            $tesis = $this->Tesis->read(null, $id);
            $this->set('tipo_tesis', $this->Tesis->tipoTesis);
            $this->set('tesis', $tesis);
        }
    }
    
    /**
     * editar(): Obtiene la Tesis con el ID = $id y muestra la vista para editarlo.
     * @param Integer $id
     * @throws NotFoundException Si no encuentra la Tesis con el respectivo ID.
     */
    public function editar($id = null) {
        $this->Tesis->id = $id;
        if (!$this->Tesis->exists()) {
            throw new NotFoundException('Articulo no existe.');
        }
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        $this->set('tipo_tesis', $this->Tesis->tipoTesis);
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Tesis->save($this->request->data)) {
                $this->request->data['Tesis']['id'] = $id;
                $this->success('Se han actualizado los datos.');
            } else {
                $this->error('No se han podido guardar los datos.');
            }
        } else {
            $this->Tesis->recursive = -1;
            $this->request->data = $this->Tesis->read(null, $id);
        }
    }
    
    /**
     * Borra una Tesis con ID = $id, verificando si el usuario posee permisos para borrar la Tesis.
     * @param Integer $id Identificador de Tesis.
     * @throws MethodNotAllowedException Si el método de la petición no es POST o DELETE
     * @throws NotFoundException Si no encuentra la Tesis con el respectivo ID.
     */
    public function borrar($id = null) {
        $this->autoRender = false;
        
        if (!($this->request->is('post') || $this->request->is('delete'))) {
            throw new MethodNotAllowedException();
        }
        $this->Tesis->id = $id;
        if (!$this->Tesis->exists()) {
            throw new NotFoundException('Tesis no existe o ya ha sido borrada.');
        }
        
        $isOwnedBy = $this->Tesis->isOwnedBy($id, $this->Auth->user('id'));
        if ($isOwnedBy) {
            if ($this->Tesis->delete()) {
                $this->success('La Tesis ha sido borrada.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->error('La Tesis no se ha podido borrar.');
            }
        } else {
            $this->error('No tienes los permisos para esta acción.');
            $this->redirect(array('action' => 'index'));
        }
        //$this->redirect(array('action' => 'index'));
    }
    
    /**
     * search(): Busca una Tesis en base a un patrón. 
     */
    public function search() {
        $query = $this->params['url']['q'];
        if (!$query) {
            $this->set('tesis', array());
        } else {
            $this->set('tesis', $this->Tesis->findByQuery($query, $this->Auth->user('id')));
        }
        $this->set('tipo_tesis', $this->Tesis->tipoTesis);
    }
    
    
    /**
     * Obtiene las Tesis del usuario que ha iniciado sesión.
     * @param String $type Formato en que exportará las Tesis (XML, PDF, TXT).  
     */
    public function exportar($type = null) {
        $this->Tesis->recursive = -1;
        $results = $this->Tesis->findAllByUserId($this->Auth->user('id'));
        $this->set('tipo_tesis', $this->Tesis->tipoTesis);
        $this->_exportar($results, $type);
    }
    
    /**
     * Obtiene todas las Tesis de la base de Datos y los exporta a un archivo (XML, PDF, TXT).
     * @param String $type Formato en que exportará las Tesis (XML, PDF, TXT). 
     */
    public function admin_exportar($type = null) {
        $this->Tesis->recursive = -1;
        $results = $this->Tesis->find('all');
        $this->_exportar($results, $type);
    }
}
?>
