<?php

class CursosController extends AppController {
    public $name = 'Cursos';
    public $components = array('Session');
    
    public $paginate = array(
        'limit' => 20,
        'order' => array(
            'Curso.anio_publicacion' => 'asc',
            'Curso.nombre' => 'asc'
        )
    );
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('json_index');
    }
    
    public function index() {
        $this->Curso->recursive = -1;
        $this->paginate['conditions'] = array('Curso.user_id' => $this->Auth->user('id'));
        $cursos = $this->paginate();
        $this->set('tipo_curso', $this->Curso->tipoCurso);
        $this->set('cursos', $cursos);
    }
    
    public function admin_index() {
        $this->Curso->recursive = -1;
        $this->set('tipo_curso', $this->Curso->tipoCurso);
        $this->set('cursos', $this->paginate());
    }
    
    public function json_index($field = null, $query = null) {
        $this->autoRender = false;
        $conditions = array(
            'conditions' => array('Articulo.' . $field . ' LIKE' => '%' . $query .'%'),
            'fields' => 'DISTINCT Articulo.' . $field,
            'order' => 'Articulo.' . $field,
        );
        
        $results = $this->Curso->find('all', $conditions);
        $json_array = array();
        foreach ($results as $key => $value) {
            array_push($json_array, $value['Articulo'][$field]);
        }
        echo json_encode($json_array);
    }
    
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
    
    public function ver($id = null) {
        $this->Curso->id = isset($id) ? $id : $this->request->params['id'];
        if (!$this->Curso->exists()) {
            throw new NotFoundException('Articulo que buscas no existe.');
        } else {
            $this->Curso->recursive = -1;
            $curso = $this->Curso->read(null, $id);
            $this->set('tipo_curso', $this->Curso->tipoCurso);
            $this->set('curso', $curso);
        }
    }
    
    public function editar($id = null) {
        $this->Curso->id = $id;
        if (!$this->Curso->exists()) {
            throw new NotFoundException('Articulo no existe.');
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
    
    public function search() {
        $query = $this->params['url']['q'];
        if (!$query) {
            $this->set('cursos', array());
        } else {
            $this->set('cursos', $this->Curso->findByQuery($query, $this->Auth->user('id')));
        }

        $this->set('tipo_curso', $this->Curso->tipoCurso);
        $this->render('index');
    }
    
    public function exportar($type = null) {
        $this->Curso->recursive = -1;
        $results = $this->Curso->findAllByUserId($this->Auth->user('id'));
        $this->set('tipo_curso', $this->Curso->tipoCurso);
        $this->_exportar($results, $type);
    }
}
?>
