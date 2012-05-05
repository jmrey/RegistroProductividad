<?php

App::uses('CakeEmail', 'Network/Email');

class FeedbackController extends AppController {
    var $name = 'Feedback';
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'issues');
    }
    
    public function index() {
        if ($this->request->is('post')) {
            $this->Feedback->set($this->request->data);
            if ($this->Feedback->validates()) {
                $this->_sendFeedback($this->request->data['Feedback']);
                $this->success('¡Gracias! Tu mensaje ha sido recibido.');
            }
        }
    }
    
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
    
    private function _sendIssues($issueDetails = null) {
        $emailUser = $issueDetails['user_email'];
        $this->_sendEmail('yeah.mue@gmail.com', 'Issue by: ' . $emailUser , 'issues', array(
            'url' => $issueDetails['url'],
            'user' => $issueDetails['user'],
            'email' => $emailUser,
            'detalles' => $issueDetails['resumen']
        ));
    }
    
    private function _sendFeedback($feedbackDetails = null) {
        $emailUser = $feedbackDetails['email'];
        $this->_sendEmail('yeah.mue@gmail.com', 'Feedback: ' . $emailUser , 'feedback', array(
            'user' => $feedbackDetails['nombre'],
            'email' => $emailUser,
            'detalles' => $feedbackDetails['detalles']
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
