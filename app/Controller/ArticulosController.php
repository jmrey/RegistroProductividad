<?php

/**
 * Controlador de Artículos.
 * @class ArticulosController 
 */
class ArticulosController extends AppController {
    /**
     * Nombre del Controlador.
     * @var String
     */
    public $name = 'Articulos';
    /**
     * Componentes necesarios que utiliza el Controlador.
     * @var Array 
     */
    public $components = array('Session');
    
    /**
     * Opciones para la paginación de los Artículos.
     * @var Array 
     */
    public $paginate = array(
        'limit' => 20,
        'order' => array(
            'Articulo.anio_publicacion' => 'asc',
            'Articulo.titulo' => 'asc'
        )
    );
    
    /**
     * Función llamada antes de ejecutar cualquier acción del controlador. 
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('json_index');
        $this->set('title_for_layout', $this->name);
    }
    
    /**
     * index(): Recupera todos los artículos asociados al usuario que ha iniciado sesión.
     */
    public function index() {
        $this->Articulo->recursive = -1;
        $this->paginate['conditions'] = array('Articulo.user_id' => $this->Auth->user('id'));
        $articulos = $this->paginate();
        $this->set('articulos', $articulos);
    }
    
    /**
     * admin_index(): Recupera todos los artículos que existen en la Base de Datos. 
     */
    public function admin_index() {
        $this->Articulo->recursive = -1;
        $this->set('articulos', $this->paginate());
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
            'conditions' => array('Articulo.' . $field . ' LIKE' => '%' . $query .'%'),
            'fields' => 'DISTINCT Articulo.' . $field,
            'order' => 'Articulo.' . $field,
        );
        
        $results = $this->Articulo->find('all', $conditions);
        $json_array = array();
        foreach ($results as $key => $value) {
            array_push($json_array, $value['Articulo'][$field]);
        }
        echo json_encode($json_array);
    }
    
    /**
     * nuevo(): Crea un nuevo Artículo. 
     */
    public function nuevo() {
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        //pr($this->request->data);
        if ($this->request->is('post')) {
            $this->Articulo->create();
            $this->request->data['Articulo']['user_id'] = $this->Auth->user('id');
            if ($this->Articulo->save($this->request->data)) {
                $this->success('Se ha registrado el artículo satisfactoriamente.');
                if ($this->request->data['Articulo']['add_files'] == 1) {
                    $this->redirect('/articulos/' . $this->Articulo->id . '/archivos');
                } else {
                    $this->redirect('/articulos/' . $this->Articulo->id);
                }
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    /**
     * ver(): Muestra un artículo con el ID = $id.
     * @param Integer $id Identificador del Artículo
     * @throws NotFoundException Si no encuentra al artículo con el respectivo ID.
     */
    public function ver($id = null) {
        $this->Articulo->id = isset($id) ? $id : $this->request->params['id'];
        if (!$this->Articulo->exists()) {
            throw new NotFoundException('Articulo que buscas no existe.');
        } else {
            $this->Articulo->recursive = -1;
            $articulo = $this->Articulo->read(null, $id);
            $this->set('articulo', $articulo);
        }
    }
    
    /**
     * editar(): Obtiene el artículo con el ID = $id y muestra la vista para editarlo.
     * @param Integer $id
     * @throws NotFoundException Si no encuentra aun artículo con el respectivo ID.
     */
    public function editar($id = null) {
        $this->Articulo->id = $id;
        if (!$this->Articulo->exists()) {
            throw new NotFoundException('Articulo no existe.');
        }
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Articulo->save($this->request->data)) {
                $this->request->data['Articulo']['id'] = $id;
                $this->success('Se han actualizado los datos.');
            } else {
                $this->error('No se han podido guardar los datos.');
            }
        } else {
            $this->Articulo->recursive = -1;
            $this->request->data = $this->Articulo->read(null, $id);
        }
    }
    
    /**
     * Borra un artículo con ID = $id, verificando si el usuario posee permisos para borrar el artículo.
     * @param Integer $id Identificador de Artículo.
     * @throws MethodNotAllowedException Si el método de la petición no es POST o DELETE
     * @throws NotFoundException Si no encuentra al artículo con el respectivo ID.
     */
    public function borrar($id = null) {
        $this->autoRender = false;
        
        if (!($this->request->is('post') || $this->request->is('delete'))) {
            throw new MethodNotAllowedException();
        }
        $this->Articulo->id = $id;
        if (!$this->Articulo->exists()) {
            throw new NotFoundException('Articulo no existe o ya ha sido borrado.');
        }
        
        $isOwnedBy = $this->Articulo->isOwnedBy($id, $this->Auth->user('id'));
        if ($isOwnedBy) {
            if ($this->Articulo->delete()) {
                $this->success('El articulo ha sido borrado.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->error('El articulo no se ha podido borrar.');
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
            $this->set('articulos', array());
        } else {
            $this->set('articulos', $this->Articulo->findByQuery($query, $this->Auth->user('id')));
        }
    }
    
    /**
     * Obtiene los artículos del usuario que ha iniciado sesión.
     * @param String $type Formato en que exportará los artículos (XML, PDF, TXT).  
     */
    public function exportar($type = null) {
        $this->Articulo->recursive = -1;
        $results = $this->Articulo->findAllByUserId($this->Auth->user('id'));
        $this->_exportar($results, $type);
    }
    
    /**
     * Obtiene todos los artículos de la base de Datos y los exporta a un archivo (XML, PDF, TXT).
     * @param String $type Formato en que exportará los artículos(XML, PDF, TXT). 
     */
    public function admin_exportar($type = null) {
        $this->Articulo->recursive = -1;
        $results = $this->Articulo->find('all');
        $this->_exportar($results, $type);
    }
}
?>
