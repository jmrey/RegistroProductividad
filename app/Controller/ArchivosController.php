<?php

/**
 *  Controlador de Archivos
 * 
 *  @extends AppController
 */
class ArchivosController extends AppController {
    /**
     * Nombre del Controlador
     * @var String
     */
    public $name = 'Archivos';
    /**
     * Componentes del Controlador
     * @var Array
     */
    public $components = array('Session', 'RequestHandler');
    /**
     * Ayudantes del Controlador
     * @var Array 
     */
    public $helpers = array('Number');
    
    /**
     *  Función llamada antes de ejecutar cada acción del controlador.
     *  @return void
     */
    function beforeFilter() {
        // Llama a beforeFilter de AppController.
        parent::beforeFilter();

        // Aquí desactivamos el componente de Seguridad.
        $noSecurityActions = array('add', 'index');
        if(isset($this->Security) && in_array($this->action, $noSecurityActions)){
            $this->Components->disable('Security');
        }
    }
    
    /**
     * index(): Muestra el archivo con el respectivo ID y el tipo de contenido.
     * 
     * @param Integer $id Identificador del Archivo.
     * @param String $content Tipo de contenido del Archivo
     * @throws NotFoundException Si el ID y el tipo de contenido no es encontrado.
     */
    public function index($id = null, $content = null) {
        $result = $this->Archivo->getContent($content, $id);
        if (!empty($result)) {
            $archivos = $this->Archivo->findAllByContentTypeAndContentId($content, $id);
            $result = array_shift($result);
            if (isset($result['titulo'])) {
                $title_for_layout = 'Archivos de ' . $result['titulo'];
            } else if (isset($result['nombre'])) {
                $title_for_layout = 'Archivos de ' . $result['nombre'];
            }
            $this->set(compact('id','content', 'archivos'));
            $this->set('useJFileUpload', true);
            $this->set('title_for_layout', $title_for_layout);
        } else {
            throw new NotFoundException('El contenido ' . $id . ' de ' . $content . ' no existe.');
        }
    }

    /**
     * agregar(): Registra un nuevo archivo.
     * @param String $content Tipo de contenido
     */
    public function agregar($content = null) {
        $this->layout = false;
        if ($this->request->is('post')) {
            $file = 'Error';
            if($this->Archivo->existsContent($content, $this->request->data['Archivo']['content_id'])) {
                ini_set('memory_limit', '200M');
                ini_set('post_max_size', '100M');
                ini_set('upload_max_filesize', '120M');
                
                $archivo = $this->request->data['Archivo'];
                $this->Archivo->create();
                
                $archivo['content_type'] = $content;
                $archivo['user_id'] = $this->Auth->user('id');
                $archivo['size'] = $archivo['file']['size'];
                $archivo['file']['name'] = $this->Auth->user('username') . '_' . date('Ymd') . '_' . $archivo['file']['name'];
                if ($this->Archivo->save($archivo)) {
                    // Get the possibly changed filename from the DB.  Thank you Jens.
                    $name = $this->Archivo->findById($this->Archivo->id);
                    // Set up the data to send back to the browser.
                    $file = array();
                    $file['name'] = $name['Archivo']['basename']; 
                    $file['size'] = $name['Archivo']['size'];
                    $file['url'] = $name['Archivo']['url'];
                    $file['thumbnail_url'] = $name['Archivo']['thumbnail_url'];
                    $file['delete_type'] = 'post';
                    $file['delete_url'] = '/archivos/borrar/' . $this->Archivo->id;
                }
            }
            // Don't send back a normal CakePHP page response.
            //$this->RequestHandler->renderAs($this, 'ajax');

            // Must be a JSON object inside an array, thus the square brackets.
            $this->set('file', '['.json_encode($file).']');
            $this->render('/Elements/ajax');
        }
    }
    
    /**
     * borrar(): Borra el archivo.
     * 
     * @param Integer $id Identificador de Archivo.
     * @throws MethodNotAllowedException Si el método de la petición no es POST o DELETE
     * @throws NotFoundException Si no encuntra el archivo con el ID asociado.
     */
    public function borrar($id = null) {
        $this->autoRender = false;

        if (!($this->request->is('post') || $this->request->is('delete'))) {
            throw new MethodNotAllowedException();
        }
        $this->Archivo->id = $id;
        if (!$this->Archivo->exists()) {
            throw new NotFoundException('Archivo no existe o ya ha sido borrada.');
        }
        
        $isOwnedBy = $this->Archivo->isOwnedBy($id, $this->Auth->user('id'));
        if ($isOwnedBy) {
            if ($this->Archivo->delete()) {
                $this->success('El archivo ha sido borrado.');
            } else {
                $this->error('El archivo no se ha podido borrar.');
            }
        } else {
            $this->error('No tienes los permisos para está acción.');
        }
    }
}
?>
