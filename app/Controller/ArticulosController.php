<?php

class ArticulosController extends AppController {
    public $name = 'Articulos';
    public $components = array('Session');
    public $uses = array('Articulo', 'Contenido');
    
    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow('add', 'login', 'logout');
    }
    
    public function index() {
        $this->Articulo->recursive = -1;
        $conditions = array('Articulo.user_id' => $this->Auth->user('id'));
        $articulos = $this->Articulo->find('all', array(
            'conditions' => $conditions 
        ));    
        $this->set('articulos', $articulos);
    }
    
    public function admin_index() {
        $this->Articulo->recursive = -1;
        $this->set('articulos', $this->paginate());
        $this->render('index'); 
    }
    
    public function agregar() {
        if ($this->request->is('post')) {
            $this->Articulo->create();
            $this->request->data['Articulo']['user_id'] = $this->Auth->user('id');
            if ($this->Articulo->save($this->request->data)) {
                $this->success('Se ha registrado el artículo satisfactoriamente.');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    public function ver($id = null) {
        $this->Articulo->id = $id;
        if (!$this->Articulo->exists()) {
            throw new NotFoundException('Articulo que buscas no existe.');
        } else {
            $this->Articulo->recursive = -1;
            $articulo = $this->Articulo->read(null, $id);
            $this->set('articulo', $articulo);
        }
    }
    
    public function editar($id = null) {
        $this->Articulo->id = $id;
        if (!$this->Articulo->exists()) {
            throw new NotFoundException('Articulo no existe.');
        }
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
    
    public function exportar($type = null) {
        $this->layout = false;
        //if ($this->request->is('get')) {
        $this->Articulo->recursive = -1;
        $conditions = array('Articulo.user_id' => $this->Auth->user('id'));
        $articulos = $this->Articulo->find('all', array(
            'conditions' => $conditions 
        ));
        $force_downloads = $this->Contenido->getPropertyValue('force_downloads', 'bool');
        
        if ($type == 'txt') {
            $this->response->type('txt');
            if ($force_downloads) {
                $this->response->download('mis-articulos.txt');
            }
            $this->response->disableCache();
            $this->set('articulos', $articulos);
            $this->render('export_txt');
        } else if ($type == 'xml') {
            $this->response->type('xml');
            if ($force_downloads) {
                $this->response->download('mis-articulos.xml');
            }
            $this->response->disableCache();
            $this->set('articulos', $this->_fix_assoc_array($articulos));
            $this->render('export_xml');
        } else if ($type == 'pdf') {
            $this->layout = 'pdf';
            $this->response->type('pdf');
            if ($force_downloads) {
                $this->response->download('mis-articulos.pdf');
            }
            $this->response->disableCache();
            $this->set('articulos', $articulos);
            $this->render('export_pdf');
        }
    }
    
    private function _fix_assoc_array($array = array()) {
        $assoc_articulos = array('articulo' => array());
        foreach ($array as $key => $value) {
            array_push($assoc_articulos['articulo'], $value['Articulo']);
        }
        return array('articulos' => $assoc_articulos);
    }
}
?>
