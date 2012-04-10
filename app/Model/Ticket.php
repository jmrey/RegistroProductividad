<?php
App::uses('AuthComponent', 'Controller/Component');

class Ticket extends AppModel {
    public $name = 'Ticket';
    public $useTable = 'tickets';
     
    private function purgeTickets() {
        $this->deleteAll('Ticket.expires <= now() LIMIT 1');
    }
    
    public function deleteTicket($hash) {
        $this->deleteAll(array('hash' => $hash));
        $this->purgeTickets();
    }
    
    public function checkTicket($hash) {
        $this->purgeTickets();
        return $this->findByHash($hash);
    }
    
    public function getExpirationDate($days = 1) {
        $date = strftime('%c');
        $date = strtotime($date);
        $date += ($days * 24 * 60 * 60);
        $expired = date('Y-m-d H:i:s', $date);
        return $expired; 
    }
}
?>
