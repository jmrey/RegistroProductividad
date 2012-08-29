<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Clase base de los controladores.
 *
 * En esta clase se agregan los métodos y propiedades que deberán tener todos los controladores.
 *
 * @package       Cake.Controller
 * @link http://book.cakephp.org/view/957/The-App-Controller
 */
class AppController extends Controller {
    
    /**
     * Array que contiene los componentes que necesita el controlador, en este caso, los componentes
     * que necesita la clase base AppController.
     * @var Array 
     */
    public $components = array(
        'Session',
        'Auth' => array(
            'authError' => "No tienes los suficientes privilegios para esta acción.",
            'loginRedirect' => array('admin' => 0,'controller' => 'dashboard', 'action' => 'index'),
            'logoutRedirect' => '/',
            'authorize' => array('Controller')
        )
    );
    
    /**
     * Función llamada antes de ejecutar cada acción del controlador.
     */
    public function beforeFilter() {
        $this->Auth->allow('display');
        $this->set('authUser', $this->Auth->user());
        $this->set('isAdmin', $this->isAdmin());
    }
    
    /**
     * Función llamada después de que cada acción del controlador ha sido ejecutada,
     * pero antes de renderizar su vista.
     */
    public function beforeRender()
    {
        // Sólo compila si no es un entorno de producción.
        if (Configure::read('debug') > 0) {
            // Importa los modulos necesarios.
            App::import('Vendor', 'lessc');
 
            if (defined('WEBROOT_DIR')) {
                //$PUBLIC_HTML_PATH = ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS;
                $PUBLIC_HTML_PATH = ROOT . DS . WEBROOT_DIR . DS;
                 
                // Array de los archivos less.
                $css_array = array('bootstrap', 'main');
                
                for ($i = 0; $i < count($css_array); $i++) {
                    // Establece el directorio donde está el archivo LESS.
                    $less = $PUBLIC_HTML_PATH . 'less' . DS . $css_array[$i] .'.less';
 
                    // Establece dónde se guardará el CSS compilado.
                    $css = $PUBLIC_HTML_PATH . 'css' . DS . $css_array[$i] . '.css';
 
                    // Compila el archivo LESS
                    lessc::ccompile($less, $css);  
                }
            }
        }
        
        
        if ($this->request->is('get')) {
            $referer = $this->referer();
            $this->Session->write('App.referer', $referer);
            $this->set('referer', $referer);
        } else {
            $this->set('referer', array('action' => 'index'));
        }
        // Llama a la función de la clase padre 'Controller'.
        parent::beforeRender();
    }
    
    /**
     * Actualiza los datos de la Sesión del usuario que ha ingresado sus credenciales.
     * @param String $field
     * @param String $value 
     */
    function refreshAuth($field = '', $value = '') {
        if ($this->Auth->user()) {
            if (!empty($field) && !empty($value)) {
                $this->Session->write($this->Auth->sessionKey .'.'. $field, $value);
            } else {
                if (isset($this->User)) {
                    $user = $this->User->read(false, $this->Auth->user('id'));
                    
                } else {
                    $user = ClassRegistry::init('User')->findById($this->Auth->user('id'));
                    //$this->Auth->login(ClassRegistry::init('User')->read(null, $this->Auth->user('id')));
                }
                $this->Auth->login($user['User']);
                $this->set('authUser', $this->Auth->user());
            }
        }
    }
    
    /**
     * Verifica si el Usuario es administrador.
     * Si la propiedad status es igual a 2, entonces el usuario es administrador.
     * @param User $user
     * @return boolean 
     */
    public function isAdmin($user = null) {
        if ($user === null) {
            $user = $this->Auth->user();
        }
        if (isset($user['status']) && $user['status'] == 2) {
            return true;
        }
        return false;
    }
    
    /**
     * Verifica si el usuario está autorizado para determinadas acciones de los controladores.
     * @param User $user
     * @return boolean 
     */
    public function isAuthorized($user) {
        if (!empty($this->params['prefix']) && ($this->params['prefix'] == 'admin')) {
            if ($this->Auth->user('status') != 2 ) {
                $this->redirect(array('admin' => 0, 'controller' => 'dashboard', 'action' => 'index'));
                return false;
            }
            return true;
        }
        return isset($user);
    }
    
    /**
     * Establece mensajes en las sesiones.
     * @param String $message
     * @param String $type
     * @param String $key 
     */
    public function alert($message, $type = 'warning', $key = null) {
        $this->Session->setFlash($message, 'alert', array('type' => 'alert-' . $type));
    }
    
    /**
     * Establece mensajes de error.
     * @param String $message 
     */
    public function error($message) {
        $this->alert($message, 'error');
    }
    
    /**
     * Establece mensajes de éxito.
     * @param String $message 
     */
    public function success($message) {
        $this->alert($message, 'success');
    }
    
    /**
     * Establece mensajes de advertencia.
     * @param String $message 
     */
    public function warning($message) {
        $this->alert($message, 'warning');
    }
    
    /**
     * Establece mensajes de información.
     * @param String $message 
     */
    public function info($message) {
        $this->alert($message, 'info');
    }
    
    /**
     * Función que permite exportar los datos de los modelos en PDF, TXT o XML.
     * 
     * @param Array $results
     * @param String $type 
     */
    function _exportar($results = array(), $type = null) {
        $this->layout = false;
        $modelName = strtolower($this->name);
        
        $force_downloads = (bool)$this->Session->read('App.settings.forzar_descargas');
        
        if ($type == 'txt') {
            $this->response->type('txt');
            if ($force_downloads) {
                $this->response->download($modelName . '.txt');
            }
            $this->response->disableCache();
            $this->set($modelName, $results);
            $this->render('export_txt');
        } else if ($type == 'xml') {
            $this->response->type('xml');
            if ($force_downloads) {
                $this->response->download($modelName . '.xml');
            }
            $this->response->disableCache();
            $this->set($modelName, $this->_fixAssociativeArray($results));
            $this->render('export_xml');
        } else if ($type == 'pdf') {
            $this->layout = 'pdf';
            $this->response->type('pdf');
            if ($force_downloads) {
                $this->response->download($modelName . '.pdf');
            }
            $this->response->disableCache();
            $this->set($modelName, $results);
            $this->render('export_pdf');
        }
    }
    
    /**
     * Arregla el array de contenidos para que puede ser parseado a un objeto XML.
     * @param Array $array
     * @return array 
     */
    private function _fixAssociativeArray($array = array()) {
        $modelName = $this->modelKey;
        $assoc_articulos = array($modelName => array());
        foreach ($array as $key => $value) {
            array_push($assoc_articulos[$modelName], array_shift($value));
        }
        $array = array($this->name => $assoc_articulos);
        return $array;
    }
}
