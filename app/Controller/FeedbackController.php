<?php

App::uses('CakeEmail', 'Network/Email');

/**
 * Controlador de Retroalimentación
 */
class FeedbackController extends AppController {
    /**
     * Nombre del Controlador.
     * @var String
     */
    var $name = 'Feedback';
    
    /**
     * Función llamada antes de ejecutar cualquier acción del controlador.
     * Permite utlizar las acciones index e issues sin que el usuario haya iniciado sesión. 
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'issues');
    }
    
    /**
     * index(): Permite al usuario enviar mensajes de retroalimentación.
     */
    public function index() {
        if ($this->request->is('post')) {
            $this->Feedback->set($this->request->data);
            if ($this->Feedback->validates()) {
                $this->_sendFeedback($this->request->data['Feedback']);
                $this->success('¡Gracias! Tu mensaje ha sido recibido.');
            }
        }
    }
    
    /**
     * issues(): Acción que permite al usuario reporta algún error en la aplicación.
     */
    public function issues() {
        if ($this->request->is('post')) {
            $error = $this->request->data['Error'];
            $this->_sendIssues($error);
            $this->success('¡Gracias! El error ha sido reportado.');
            $this->set('error', $error);
        } else {
            $this->redirect(array('action' => 'index'));
        }
        
    }
    
    /**
     * Función para enviar mensajes de errores.
     * @param Array $issueDetails Array que contiene la url y detalles dónde ocurrió el error además del email y nombre del usuario.
     */
    private function _sendIssues($issueDetails = null) {
        $emailUser = $issueDetails['user_email'];
        $this->_sendEmail('yeah.mue@gmail.com', 'Issue by: ' . $emailUser , 'issues', array(
            'url' => $issueDetails['url'],
            'user' => $issueDetails['user'],
            'email' => $emailUser,
            'detalles' => $issueDetails['resumen']
        ));
    }
    
    /**
     * Función para enviar mensajes de retroalimentación.
     * @param Array $feedbackDetails Array que contiene el email, nombre y mensaje del usuario.
     */
    private function _sendFeedback($feedbackDetails = null) {
        $emailUser = $feedbackDetails['email'];
        $this->_sendEmail('yeah.mue@gmail.com', 'Feedback: ' . $emailUser , 'feedback', array(
            'user' => $feedbackDetails['nombre'],
            'email' => $emailUser,
            'detalles' => $feedbackDetails['detalles']
        ));
    }
    
    /**
     * Envia un email a $mail, con el asunto $subject, utilizando la plantilla $template.
     * @param String $mail Correo electrónico del destinatario.
     * @param String $subject Asunto del correo electrónico.
     * @param String $template Plantilla que se usará al enviar.
     * @param Array $vars Array asociativo de variables que utiliza la plantilla.
     */
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
