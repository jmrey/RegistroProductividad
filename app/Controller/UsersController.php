<?php

App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController {
    public $name = 'Users';
    public $components = array('Session');
    //public $uses = array('User', 'Contenido');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $allowActions = array('add', 'login', 'logout', 'validar', 'resetpassword', 'ticket');
        if ($this->Session->check('tokenreset')) {
            array_push($allowActions, 'nuevopassword');
        }
        $this->Auth->allow($allowActions);
    }
    
    public function login() {
        if ($this->request->is('post')) {
            $user = $this->User->findByUsername($this->request->data['User']['username']);
            if ($user != null && $user['User']['status'] <= 0) {
                $this->error('Tu cuenta no ha sido verificada');
            } else {
                if ($this->Auth->login()) {
                    $this->loadModel('Contenido');
                    $this->Session->write('App.settings', $this->Contenido->getProperties());
                    $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
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
    
    public function admin_login() {
        $this->redirect(array('admin' => 0, 'action' => 'login'));
    }
    
    public function logout() {
        $this->redirect($this->Auth->logout());
    }
    
    public function admin_index() {
        $this->User->recursive = -1;
        $this->set('deptos', $this->User->deptosArray);
        $this->set('users', $this->paginate());
    }
    
    public function add() {
        $this->loadModel('Contenido');
        $this->loadModel('Escuela');
        $this->loadModel('Departamento');
        if ($this->request->is('post')) {
            $validate_accounts = $this->Contenido->getPropertyValue('validate_accounts', 'bool');
            $this->request->data['User']['status'] = (!$validate_accounts) ? 1 : 0;
            $this->request->data['User']['keycode'] = Security::hash(date('mdY').rand(4000000,4999999));
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                if ($validate_accounts) {
                    $this->_sendKeyCode(
                            $this->request->data['User']['email'],
                            $this->request->data['User']['keycode']
                    );
                }
                $this->success('Te has registrado satisfactoriamente.');
            } else {
                $this->warning('Ha ocurrido un problema. Verifica tus datos.');
            }
            $this->set('deptos', $this->Departamento->listDeptosFromEscuela($this->request->data['User']['escuela']));
        } else {
            if($this->Auth->user()) {
                $this->redirect($this->Auth->redirect());
            }
        }
        $this->set('escuelas', $this->Escuela->listEscuelas());
    }
    
    public function perfil() {
        $this->loadModel('Escuela');
        $this->loadModel('Departamento');
        $this->set('escuela', $this->Escuela->listEscuelas());
        $this->set('depto', $this->Departamento->listDeptosFromEscuela($this->Auth->user('escuela')));
    }
    
    public function admin_perfil($id = null) {
        if (!$id) {
            $this->redirect(array('admin' => 0, 'action' => 'perfil'));
        }
        $this->User->id = $id;
        if (!$this->User->exists()) { 
            throw new NotFoundException('Usuario no existe.', 404);
        }
        $this->set('deptos', $this->User->deptosArray);
        $user = $this->User->read(null, $id);
        $this->set('user', $user['User']);
    }
    
    public function edit() {
        $this->loadModel('Contenido');
        $this->loadModel('Escuela');
        $this->loadModel('Departamento');
        //  El Usuario sólo puede editar su propio perfil, por eso se pasa su propio id.
        $id = $this->Auth->user('id');
        $this->User->id = $id;
        
        if (!$this->User->exists()) {
            throw new NotFoundException('Usuario no existe.');
        }
        $deptos = array();

        if ($this->request->is('post') || $this->request->is('put')) {
            // Se sobreescrube el id por el id correcto (sólo por seguridad).
            $this->request->data['User']['id'] = $id;
            $this->request->data['User']['keycode'] = Security::hash(date('mdY').rand(4000000,4999999));
            $deptos = $this->Departamento->listDeptosFromEscuela($this->request->data['User']['escuela']);
            /* El usuario solo puede actualizar sólo los siguientes campos. */
            $fieldList = array('id', /*'email',*/'nombre', 'escuela', 'depto', 'no_empleado', 'keycode');
            if ($this->User->save($this->request->data, true, $fieldList)) {
                $this->refreshAuth();
                $this->success('Se han actualizado los datos satisfactoriamente.');
                $this->redirect(array('action' => 'perfil'));
            } else {
                $this->error('No se han podido actualizar tus datos.');
            }
        } else {
            $user = $this->User->read(null, $id);
            $deptos = $this->Departamento->listDeptos($user['User']['escuela']);
            $this->request->data = $user;
            unset($this->request->data['User']['password']);
            unset($this->request->data['User']['id']);
        }
        $this->set('escuelas', $this->Escuela->listEscuelas());
        $this->set('deptos', $deptos);
    }
    
    public function admin_upgrade($id = null, $keycode = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException('Método no permitido.');
        }
        
        if (!parent::isAdmin()) {
            $this->warning('No tienes los suficientes permisos.');
            $this->redirect(array('admin' => 0, 'action' => 'index'));
        }
        
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException('Usuario no existe.');
        }
        
        $user = $this->User->read(null, $id);
        if ($keycode === $user['User']['keycode']) {
            $this->User->set('status' , 2);
            if ($this->User->save()) {
                $this->success('Se ha cambiado el rol con éxito.');
            } else {
                $this->warning('Ha ocurrido un error. Intenta más tarde.');
            }
        } else {
            $this->warning('El código clave del usuario no es igual al del sistema.');
        }
        $this->redirect(array('admin' => 1, 'action' => 'perfil', $id));
        
    }
    
    public function resetpassword() {
        if ($this->request->is('post')) {
            $user = $this->User->findByEmail($this->request->data['User']['email']);
            if (empty($user)) {
                $this->warning('El correo ingresado no está registrado. Intenta con otro.');
            } else {
                //$data = array();
                $this->loadModel('Ticket');
                $keycode = Security::hash(date('mdY').rand(4000000,4999999));
                $email = $user['User']['email'];
                $this->_sendRecoverPassword($email, $keycode);
                $data['Ticket']['hash'] = $keycode;
                $data['Ticket']['data'] = $email;
                $data['Ticket']['expires'] = $this->Ticket->getExpirationDate();
                if ($this->Ticket->save($data)) {
                    $this->success('Ha sido enviado el correo con éxito a ' . $email);
                } else {
                    $this->error('Ha ocurrido un error. Intenta más tarde.');
                }
            }
        }
    }
    
    public function ticket($hash) {
        $this->loadModel('Ticket');
        $results = $this->Ticket->checkTicket($hash);
        
        if (!empty($results)) {
            $userTicket = $this->User->findByEmail($results['Ticket']['data']);
            $this->Session->write('tokenreset', $userTicket['User']['keycode']);
            $this->Ticket->deleteTicket($hash);
            $this->redirect(array('controller' => 'users', 'action' => 'nuevopassword', $userTicket['User']['keycode']));
        } else {
            $this->warning('Tu ticket ha expidado.');
            $this->redirect(array('controller' => 'users', 'action' => 'nuevopassword'));
        }
    }
    
    public function nuevopassword($keycode = null) {
        $user = $this->User->findByKeycode($keycode);
        if (!empty($user)) {
            if ($this->request->is('post') || $this->request->is('put')) {
                if($this->request->data['User']['password'] != $this->request->data['User']['confirm_password']) {
                    $this->error('Verifica que las contraseñas sean iguales.');
                } else {
                    $user['User']['password'] = $this->request->data['User']['confirm_password'];
                    $user['User']['keycode'] = Security::hash(date('mdY').rand(4000000,4999999));
                    if ($this->User->save($user)) {
                        $this->refreshAuth();
                        $this->Session->delete('tokenreset');
                        $this->success('Se ha cambiado tu contraseña con éxito.');
                        $this->redirect(array('action' => 'login'));
                    } else {
                        $this->error('Ha ocurrido un error.');
                    }
                }
            }
            $this->request->data = $user;
            unset($this->request->data['User']['password']);
        } else {
            $this->error('Tu código clave no es el correcto. No podemos cambiar tu contraseña.');
            $this->set('userFound', false);
        }
        
    }
    
    public function validar($keycode = null) {
        $this->User->recursive = -1;
        $user = $this->User->findByKeycode($keycode);
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
            $usermame = $user['User']['username'];
            $email = $user['User']['email'];
            $this->set(compact('username', 'email', 'keycode'));
        }
    }
    
    private function _sendKeyCode($email = null, $keycode = null) {
        $this->_sendEmail($email, 'Sepi: ' . $email, 'validateEmail', array(
            'email' => $email,
            'keycode' => $keycode,
            'linkDomain' => 'http://regprod.org'
        ));
    }
    
    private function _sendRecoverPassword($email = null, $keycode = null) {
        $this->_sendEmail($email, 'Sepi: ' . $email, 'recoverPassword', array(
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
