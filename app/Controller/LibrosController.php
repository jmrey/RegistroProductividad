<?php

class LibrosController extends AppController {
    public $name = 'Libros';
    public $components = array('Session');
     public $uses = array('Libro', 'Contenido');
    
    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow('add', 'login', 'logout');
    }
    
    public function index() {
        $this->Libro->recursive = -1;
        $libros = $this->Libro->findAllByUserId($this->Auth->user('id'));
        $this->set('tipo_libros', $this->Libro->tipoLibros);
        $this->set('libros', $libros);
    }
    
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
    
    public function agregar() {
        $this->set('tipo_libros', $this->Libro->tipoLibros);
        if ($this->request->is('post')) {
            $this->Libro->create();
            $this->request->data['Libro']['user_id'] = $this->Auth->user('id');
            if ($this->Libro->save($this->request->data)) {
                $this->success('Se ha registrado el artículo satisfactoriamente.');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    public function ver($id = null) {
        $this->Libro->id = $id;
        if (!$this->Libro->exists()) {
            throw new NotFoundException('Libro que buscas no existe.');
        } else {
            $this->Libro->recursive = -1;
            $libro = $this->Libro->read(null, $id);
            $this->set('libro', $libro);
        }
    }
    
    public function editar($id = null) {
        $this->set('tipo_libros', $this->Libro->tipoLibros);
        $this->Libro->id = $id;
        if (!$this->Libro->exists()) {
            throw new NotFoundException('Libro no existe.');
        }
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
            //$this->request->data['Libro']['id'] = $id;
        }
    }
    
    public function exportar($type = null) {
        $this->layout = false;
        //if ($this->request->is('get')) {
        $this->Libro->recursive = -1;
        $libros = $this->Libro->findAllByUserId($this->Auth->user('id'));
        $force_downloads = $this->Contenido->getPropertyValue('force_downloads', 'bool');
        
        if ($type == 'txt') {
            $this->response->type('txt');
            if ($force_downloads) {
                $this->response->download('mis-libros.txt');
            }
            $this->response->disableCache();
            $this->set('libros', $libros);
            $this->render('export_txt');
        } else if ($type == 'xml') {
            $this->response->type('xml');
            if ($force_downloads) {
                $this->response->download('mis-libros.xml');
            }
            $this->response->disableCache();
            $this->set('libros', $this->_fix_assoc_array($libros));
            $this->render('export_xml');
        } else if ($type == 'pdf') {
            $this->layout = 'pdf';
            $this->response->type('pdf');
            $this->set('tipo_libros', $this->Libro->tipoLibros);
            if ($force_downloads) {
                $this->response->download('mis-libros.pdf');
            }
            $this->response->disableCache();
            $this->set('libros', $libros);
            $this->render('export_pdf');
        }
    }
    
    private function _fix_assoc_array($array = array()) {
        $assoc_libros = array('libro' => array());
        foreach ($array as $key => $value) {
            array_push($assoc_libros['libro'], $value['Libro']);
        }
        return array('libros' => $assoc_libros);
    }
}
?>
