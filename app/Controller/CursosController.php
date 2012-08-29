<?php

/**
 * Controlador de Cursos.
 * @class CursosController 
 */
class CursosController extends AppController {
    /**
     * Nombre del Controlador.
     * @var String
     */
    public $name = 'Cursos';
    /**
     * Componentes necesarios que utiliza el Controlador.
     * @var Array 
     */
    public $components = array('Session');
    
    /**
     * Opciones para la paginación de los Cursos.
     * @var Array 
     */
    public $paginate = array(
        'limit' => 20,
        'order' => array(
            'Curso.anio_publicacion' => 'asc',
            'Curso.nombre' => 'asc'
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
     * index(): Recupera todos los cursos asociados al usuario que ha iniciado sesión.
     */
    public function index() {
        $this->Curso->recursive = -1;
        $this->paginate['conditions'] = array('Curso.user_id' => $this->Auth->user('id'));
        $cursos = $this->paginate();
        $this->set('tipo_curso', $this->Curso->tipoCurso);
        $this->set('cursos', $cursos);
    }
    
    /**
     * admin_index(): Recupera todos los cursos que existen en la Base de Datos. 
     */
    public function admin_index() {
        $this->Curso->recursive = -1;
        $this->set('tipo_curso', $this->Curso->tipoCurso);
        $this->set('cursos', $this->paginate());
    }
    
    /**
     * json_index(): Busca los cursos en base a un campo y un patrón.
     * Los resultados son mostrados en formato JSON.
     * @param String $field
     * @param String $query 
     */
    public function json_index($field = null, $query = null) {
        $this->autoRender = false;
        $conditions = array(
            'conditions' => array('Curso.' . $field . ' LIKE' => '%' . $query .'%'),
            'fields' => 'DISTINCT Curso.' . $field,
            'order' => 'Curso.' . $field,
        );
        
        $results = $this->Curso->find('all', $conditions);
        $json_array = array();
        foreach ($results as $key => $value) {
            array_push($json_array, $value['Curso'][$field]);
        }
        echo json_encode($json_array);
    }
    
    /**
     * nuevo(): Crea un nuevo Curso. 
     */
    public function nuevo() {
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        $this->set('tipo_curso', $this->Curso->tipoCurso);
        if ($this->request->is('post')) {
            $this->Curso->create();
            $this->request->data['Curso']['user_id'] = $this->Auth->user('id');
            if ($this->Curso->save($this->request->data)) {
                $this->success('Se ha registrado el curso satisfactoriamente.');
                $this->redirect('/cursos/' . $this->Curso->id . '/archivos');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    /**
     * ver(): Muestra un curso con el ID = $id.
     * @param Integer $id Identificador del Curso
     * @throws NotFoundException Si no encuentra aun curso con el respectivo ID.
     */
    public function ver($id = null) {
        $this->Curso->id = isset($id) ? $id : $this->request->params['id'];
        if (!$this->Curso->exists()) {
            throw new NotFoundException('Curso que buscas no existe.');
        } else {
            $this->Curso->recursive = -1;
            $curso = $this->Curso->read(null, $id);
            $this->set('tipo_curso', $this->Curso->tipoCurso);
            $this->set('curso', $curso);
        }
    }
    
    /**
     * editar(): Obtiene el curso con el ID = $id y muestra la vista para editarlo.
     * @param Integer $id
     * @throws NotFoundException Si no encuentra aun curso con el respectivo ID.
     */
    public function editar($id = null) {
        $this->Curso->id = $id;
        if (!$this->Curso->exists()) {
            throw new NotFoundException('Curso no existe.');
        }
        $this->loadModel('Contenido');
        $message_autors = array(
            'total' => $this->Contenido->getPropertyValue('message_total_autor'),
            'pos' => $this->Contenido->getPropertyValue('message_pos_autor')
        );
        $this->set('message_autors', $message_autors);
        $this->set('tipo_curso', $this->Curso->tipoCurso);
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Curso->save($this->request->data)) {
                $this->request->data['Curso']['id'] = $id;
                $this->success('Se han actualizado los datos.');
            } else {
                $this->error('No se han podido guardar los datos.');
            }
        } else {
            $this->Curso->recursive = -1;
            $this->request->data = $this->Curso->read(null, $id);
        }
    }
    
    /**
     * Borra un curso con ID = $id, verificando si el usuario posee permisos para borrar el curso.
     * @param Integer $id Identificador de Curso.
     * @throws MethodNotAllowedException Si el método de la petición no es POST o DELETE
     * @throws NotFoundException Si no encuentra aun curso con el respectivo ID.
     */
    public function borrar($id = null) {
        $this->autoRender = false;
        
        if (!($this->request->is('post') || $this->request->is('delete'))) {
            throw new MethodNotAllowedException();
        }
        $this->Curso->id = $id;
        if (!$this->Curso->exists()) {
            throw new NotFoundException('Curso no existe o ya ha sido borrado.');
        }
        
        $isOwnedBy = $this->Curso->isOwnedBy($id, $this->Auth->user('id'));
        if ($isOwnedBy) {
            if ($this->Curso->delete()) {
                $this->success('El Curso ha sido borrado.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->error('El Curso no se ha podido borrar.');
            }
        } else {
            $this->error('No tienes los permisos para está acción.');
            $this->redirect(array('action' => 'index'));
        }
        //$this->redirect(array('action' => 'index'));
    }
    
    /**
     * search(): Busca un curso en base a un patrón. 
     */
    public function search() {
        $query = $this->params['url']['q'];
        if (!$query) {
            $this->set('cursos', array());
        } else {
            $this->set('cursos', $this->Curso->findByQuery($query, $this->Auth->user('id')));
        }

        $this->set('tipo_curso', $this->Curso->tipoCurso);
    }
    
    /**
     * Obtiene los cursos del usuario que ha iniciado sesión.
     * @param String $type Formato en que exportará los cursos (XML, PDF, TXT).  
     */
    public function exportar($type = null) {
        $this->Curso->recursive = -1;
        $results = $this->Curso->findAllByUserId($this->Auth->user('id'));
        $this->set('tipo_curso', $this->Curso->tipoCurso);
        $this->_exportar($results, $type);
    }
    
    /**
     * Obtiene todos los cursos de la base de Datos y los exporta a un archivo (XML, PDF, TXT).
     * @param String $type Formato en que exportará los cursos(XML, PDF, TXT). 
     */
    public function admin_exportar($type = null) {
        $this->Curso->recursive = -1;
        $results = $this->Curso->find('all');
        $this->_exportar($results, $type);
    }
}
?>
