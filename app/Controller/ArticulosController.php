<?php

class ArticulosController extends AppController {
    public $name = 'Articulos';
    public $components = array('Session');
    
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
        $this->set('articulos', $articulos);
        //} /*else if ($this->request-is('get')) {
            
        //}*/
        $this->response->type('txt');
        $this->response->download('example.txt');
        $this->response->disableCache();
        $this->render('export_txt');
    }
}
?>
