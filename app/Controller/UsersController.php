<?php

App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController {
    public $name = 'Users';
    public $components = array('Session');
    public $uses = array('User', 'Contenido');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add', 'login', 'logout', 'validar');
    }
    
    public function login() {
        if ($this->request->is('post')) {
            $conditions = array('User.username' => $this->request->data['User']['username']);
            $user = $this->User->find('first', array(
                'conditions' => $conditions
            ));
            if ($user != null && $user['User']['status'] <= 0) {
                $this->error('Tu cuenta no ha sido verificada');
            } else {
                if ($this->Auth->login()) {
                    $this->redirect($this->Auth->redirect());
                } else {
                    $this->error('Nombre de usuario o contraseña inválidos.');
                }
            }
        } else {
            if($this->Auth->user()) {
                $this->redirect($this->Auth->redirect());
            }
        }
    }
    
    public function logout() {
        $this->redirect($this->Auth->logout());
    }
    
    public function add() {
        $this->set('deptos', $this->User->deptosArray);
        if ($this->request->is('post')) {
            $this->User->create();
            $validate_accounts = $this->Contenido->getPropertyValue('validate_accounts', 'bool');
            $keycode = Security::hash(date('mdY').rand(4000000,4999999));
            $this->request->data['User']['status'] = (!$validate_accounts) ? 1 : 0;
            $this->request->data['User']['keycode'] = $keycode;
            
            if ($this->User->save($this->request->data)) {
                if ($validate_accounts) {
                    $email = $this->request->data['User']['email'];
                    $this->_sendKeyCode($email, $keycode);
                }
                $this->success('Te has registrado satisfactoriamente.');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica tus datos.');
            }
        } else {
            if($this->Auth->user()) {
                $this->redirect($this->Auth->redirect());
            }
        }
    }
    
    public function dashboard() {
        $this->set('content_articles', $this->Contenido->getPropertyValue('content_articles', 'bool'));
        $this->set('content_books', $this->Contenido->getPropertyValue('content_books', 'bool'));
        $this->set('content_chapters', $this->Contenido->getPropertyValue('content_chapters', 'bool'));
        $this->set('content_patents', $this->Contenido->getPropertyValue('content_patents', 'bool'));
    }
    
    public function validar($keycode = null) {
        $this->User->recursive = -1;
        $conditions = array('User.keycode' => $keycode);
        $user = $this->User->find('first', array(
            'conditions' => $conditions
        ));
        if ($this->request->is('post') && $user != null) {
            $user['User']['status'] = 1;
            if($this->User->save($user['User'], true, array('status'))) {
                $this->success('Gracias. Ya puedes iniciar sesión.');
                $this->redirect(array('controller' => 'users','action' => 'login'));
            } else {
                $this->error('Ocurrió un error al actualizar tu cuenta. Intenta más tarde.');
            }
        } else if ($this->request->is('get')) {
            if ($user['User']['status'] >= 1) {
                $this->success('Tu cuenta ya ha sido activada.');
                $this->redirect(array('controller' => 'users','action' => 'login'));
            }
            $this->set('username', $user['User']['username']);
            $this->set('email', $user['User']['email']);
            $this->set('keycode', $keycode);
        }
    }
    
    public function admin_config() {
        $this->set('validate_accounts', $this->Contenido->getPropertyValue('validate_accounts', 'bool'));
        $this->set('force_downloads', $this->Contenido->getPropertyValue('force_downloads', 'bool'));
        $this->set('content_articles', $this->Contenido->getPropertyValue('content_articles', 'bool'));
        $this->set('content_books', $this->Contenido->getPropertyValue('content_books', 'bool'));
        $this->set('content_chapters', $this->Contenido->getPropertyValue('content_chapters', 'bool'));
        $this->set('content_patents', $this->Contenido->getPropertyValue('content_patents', 'bool'));
    }
    
    private function _sendKeyCode($email = null, $keycode = null) {
        $this->_sendEmail($email, 'Sepi: ' . $email, 'validateEmail', array(
            'email' => $email,
            'keycode' => $keycode,
            'linkDomain' => 'http://regprod.org'
        ));
    }
    
    private function _sendEmail($mail = null, $subject = null, $template = null, $vars = array()) {
        $email = new CakeEmail('gmail');
        $email->template($template, 'default')
            ->viewVars($vars)
            ->subject($subject)
            ->emailFormat('html')
            ->to($mail)
            ->from('sepi@gmail.com')
            ->send();
    }
}
?>
