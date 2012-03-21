<?php

class CapitulosController extends AppController {
    public $name = 'Capitulos';
    public $components = array('Session');
    public $uses = array('Capitulo', 'Contenido');
    
    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow('add', 'login', 'logout');
    }
    
    public function index() {
        $this->Capitulo->recursive = -1;
        $capitulos = $this->Capitulo->findAllByUserId($this->Auth->user('id'));
        $this->set('capitulos', $capitulos);
    }
    
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
    
    public function agregar() {
        if ($this->request->is('post')) {
            $this->Capitulo->create();
            $this->request->data['Capitulo']['user_id'] = $this->Auth->user('id');
            if ($this->Capitulo->save($this->request->data)) {
                $this->success('Se ha registrado el artículo satisfactoriamente.');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica los datos.');
            }
        }
    }
    
    public function ver($id = null) {
        $this->Capitulo->id = $id;
        if (!$this->Capitulo->exists()) {
            throw new NotFoundException('Capitulo que buscas no existe.');
        } else {
            $this->Capitulo->recursive = -1;
            $capitulo = $this->Capitulo->read(null, $id);
            $this->set('capitulo', $capitulo);
        }
    }
    
    public function editar($id = null) {
        $this->Capitulo->id = $id;
        if (!$this->Capitulo->exists()) {
            throw new NotFoundException('Capitulo no existe.');
        }
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
    
    public function exportar($type = null) {
        $this->layout = false;
        //if ($this->request->is('get')) {
        $this->Capitulo->recursive = -1;
        $capitulos = $this->Capitulo->findAllByUserId($this->Auth->user('id'));
        $force_downloads = $this->Contenido->getPropertyValue('force_downloads', 'bool');
        
        if ($type == 'txt') {
            $this->response->type('txt');
            if ($force_downloads) {
                $this->response->download('mis-capitulos.txt');
            }
            $this->response->disableCache();
            $this->set('capitulos', $capitulos);
            $this->render('export_txt');
        } else if ($type == 'xml') {
            $this->response->type('xml');
            if ($force_downloads) {
                $this->response->download('mis-capitulos.xml');
            }
            $this->response->disableCache();
            $this->set('capitulos', $this->_fix_assoc_array($capitulos));
            $this->render('export_xml');
        } else if ($type == 'pdf') {
            $this->layout = 'pdf';
            $this->response->type('pdf');
            if ($force_downloads) {
                $this->response->download('mis-capitulos.pdf');
            }
            $this->response->disableCache();
            $this->set('capitulos', $capitulos);
            $this->render('export_pdf');
        }
    }
    
    private function _fix_assoc_array($array = array()) {
        $assoc_capitulos = array('capitulo' => array());
        foreach ($array as $key => $value) {
            array_push($assoc_capitulos['capitulo'], $value['Capitulo']);
        }
        return array('capitulos' => $assoc_capitulos);
    }
}
?>
