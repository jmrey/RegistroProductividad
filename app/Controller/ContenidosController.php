<?php
/**
 * Controlador de Contenidos.
 * @class ContenidosController
 * @extends AppController 
 */
class ContenidosController extends AppController {
    /**
     * Nombre del Controlador
     * @var string 
     */
    public $name = 'Contenidos';
    /**
     * Componentes que utilizará el Controlador.
     * @var array 
     */
    public $components = array('Session');
    
    /**
     * Función llamada antes de ejecutar cualquier acción del controlador. 
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('display');
    }
    
    /**
     * Muestra el contenido con el NOMBRE = $name
     * @param String $name Nombre de Contenido
     * @throws NotFoundException Si el contenido no ha sido encontrado.
     */
    public function display($name = null) {
        $contenido = $this->Contenido->findByName($name);
        if ($contenido == null) {
            throw new NotFoundException('Contenido no existe.');
        }
        $name = $contenido['Contenido']['name'];
        if ($name === 'inicio') {
            $this->set('titulo', $this->Contenido->getValue('titulo'));
        }
        $this->set('contenido', $contenido['Contenido']);
    }
    
    /**
     * admin_add(): Permite al administrador agregar un nuevo contenido. 
     */
    public function admin_add() {
        if (!parent::isAdmin()) {
            $this->redirect('/');
        }
        if ($this->request->is('post')) {
            $this->Contenido->create();
            if ($this->Contenido->save($this->request->data)) {
                $this->success('La configuración se ha guardado satisfactoriamente.');
            } else {
                $this->warning('Ha ocurrido un problema.');
            }
        }
    }
    
    /**
     * admin_set(): Permite agregar propiedades para configurar la aplicación.
     * @param String $property Nombre de la propiedad de Contenido.
     * @param String $value Valor de la Propiedad de Conteido.
     * @throws MethodNotAllowedException Si el método de la petición no es POST o DELETE
     */
    public function admin_set($property = null, $value = null) {
        $this->autoRender = false;
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if (!parent::isAdmin()) {
            $this->redirect('/');
        }
        $response = 'error';
        if ($this->Contenido->setProperty($property, $value)) {
            $this->Session->write('App.settings.' . $property, $value);
            $response = 'success';
        }
        
        echo $response;
    }
    
    /**
     * admin_editar(): Permite al administrador editar al contenido con NOMBRE = $name.
     * @param String $name Nombre de Contenido
     * @throws NotFoundException Si el contenido no ha sido encontrado.
     */
    public function admin_editar($name = null) {
        if (!parent::isAdmin()) {
            $this->redirect('/');
        }
        $contenido = $this->Contenido->findByName($name);
        if (empty($contenido)) {
            throw new NotFoundException('Contenido no existe.');
        }
        
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Contenido->save($this->request->data)) {
                $this->request->data['Contenido']['name'] = $name;
                $this->success('Se han actualizado los datos.');
            } else {
                $this->error('No se han podido guardar los datos.');
            }
        } else {
            $this->request->data = $contenido;
        }
    }
}
?>
