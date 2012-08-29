<?php
/**
 * Controlador de los Capítulos.
 * @class CapitulosController 
 */
class CapitulosController extends AppController {
    /**
     * Nombre del Controlador.
     * @var String
     */
    public $name = 'Capitulos';
    /**
     * Componentes necesarios que utiliza el Controlador.
     * @var Array 
     */
    public $components = array('Session');
    
    /**
     * Opciones para la paginación de los capítulos.
     * @var Array 
     */
    public $paginate = array(
        'limit' => 20,
        'order' => array(
            'Capitulo.anio_publicacion' => 'asc',
            'Capitulo.titulo_capitulo' => 'asc'
        )
    );
    
    /**
     * Función llamada antes de ejecutar cualquier acción del controlador. 
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('title_for_layout', $this->name);
    }
    
    /**
     * index(): Recupera todos los capítulos asociados al usuario que ha iniciado sesión.
     */
    public function index() {
        $this->Capitulo->recursive = -1;
        $this->paginate['conditions'] = array('Capitulo.user_id' => $this->Auth->user('id'));
        $capitulos = $this->paginate();
        $this->set('capitulos', $capitulos);
    }
    
    /**
     * admin_index(): Recupera todos los capítulos que existen en la Base de Datos. 
     */
    public function admin_index() {
        $this->Capitulo->recursive = -1;
        $this->set('capitulos', $this->paginate());
    }
    
    /**
     * json_index(): Busca los articulos en base a un campo y un patrón.
     * Los resultados son mostrados en formato JSON.
     * @param String $field
     * @param String $query 
     */
    public function json_index($field = null, $query = null) {
        $this->autoRender = false;
        $conditions = array(
            'conditions' => array('Capitulo.' . $field . ' LIKE' => '%' . $query .'%'),
            'fields' => 'DISTINCT Capitulo.' . $field,
            'order' => 'Capitulo.' . $field,
        );
        
        $results = $this->Capitulo->find('all', $conditions);
        $json_array = array();
        foreach ($results as $key => $value) {
            array_push($json_array, $value['Capitulo'][$field]);
        }
        echo json_encode($json_array);
    }
    
    /**
     * nuevo(): Crea un nuevo Capítulo. 
     */
    public function nuevo() {
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        if ($this->request->is('post')) {
            $this->Capitulo->create();
            $this->request->data['Capitulo']['user_id'] = $this->Auth->user('id');
            if ($this->Capitulo->save($this->request->data)) {
                $this->success('Se ha registrado el Capítulo satisfactoriamente.');
                $this->redirect('/capitulos/' . $this->Capitulo->id . '/archivos');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    /**
     * ver(): Muestra un Capítulo con el ID = $id.
     * @param Integer $id Identificador del Capítulo
     * @throws NotFoundException Si no encuentra aun Capítulo con el respectivo ID.
     */
    public function ver($id = null) {
        $this->Capitulo->id = isset($id) ? $id : $this->request->params['id'];
        if (!$this->Capitulo->exists()) {
            throw new NotFoundException('Capitulo que buscas no existe.');
        } else {
            $this->Capitulo->recursive = -1;
            $capitulo = $this->Capitulo->read(null, $id);
            $this->set('capitulo', $capitulo);
        }
    }
    
    /**
     * editar(): Obtiene el Capítulo con el ID = $id y muestra la vista para editarlo.
     * @param Integer $id
     * @throws NotFoundException Si no encuentra aun Capítulo con el respectivo ID.
     */
    public function editar($id = null) {
        $this->Capitulo->id = $id;
        if (!$this->Capitulo->exists()) {
            throw new NotFoundException('Capitulo no existe.');
        }
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Capitulo->save($this->request->data)) {
                $this->request->data['Capitulo']['id'] = $id;
                $this->success('Se han actualizado los datos.');
            } else {
                $this->error('No se han podido guardar los datos.');
            }
        } else {
            $this->Capitulo->recursive = -1;
            $this->request->data = $this->Capitulo->read(null, $id);
        }
    }
    
    /**
     * Borra un Capítulo con ID = $id, verificando si el usuario posee permisos para borrar el Capítulo.
     * @param Integer $id Identificador de Capítulo.
     * @throws MethodNotAllowedException Si el método de la petición no es POST o DELETE
     * @throws NotFoundException Si no encuentra aun Capítulo con el respectivo ID.
     */
    public function borrar($id = null) {
        $this->autoRender = false;
        
        if (!($this->request->is('post') || $this->request->is('delete'))) {
            throw new MethodNotAllowedException();
        }
        $this->Capitulo->id = $id;
        if (!$this->Capitulo->exists()) {
            throw new NotFoundException('Capitulo no existe o ya ha sido borrado.');
        }
        
        $isOwnedBy = $this->Capitulo->isOwnedBy($id, $this->Auth->user('id'));
        if ($isOwnedBy) {
            if ($this->Capitulo->delete()) {
                $this->success('El capítulo ha sido borrado.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->error('El capítulo no se ha podido borrar.');
            }
        } else {
            $this->error('No tienes los permisos para está acción.');
            $this->redirect(array('action' => 'index'));
        }
        //$this->redirect(array('action' => 'index'));
    }
    
    /**
     * search(): Busca un Capítulo en base a un patrón. 
     */
    public function search() {
        $query = $this->params['url']['q'];
        if (!$query) {
            $this->set('capitulos', array());
        } else {
            $this->set('capitulos', $this->Capitulo->findByQuery($query, $this->Auth->user('id')));
        }
    }
    
    /**
     * Obtiene los capítulos del usuario que ha iniciado sesión.
     * @param String $type Formato en que exportará los capítulos (XML, PDF, TXT).  
     */
    public function exportar($type = null) {
        $this->Capitulo->recursive = -1;
        $results = $this->Capitulo->findAllByUserId($this->Auth->user('id'));
        $this->_exportar($results, $type);
    }
    
    /**
     * Obtiene todos los capítulos de la base de Datos y los exporta a un archivo (XML, PDF, TXT).
     * @param String $type Formato en que exportará los capítulos(XML, PDF, TXT). 
     */
    public function admin_exportar($type = null) {
        $this->Capitulo->recursive = -1;
        $results = $this->Capitulo->find('all');
        $this->_exportar($results, $type);
    }
}
?>
