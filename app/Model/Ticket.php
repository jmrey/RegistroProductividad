<?php
App::uses('AuthComponent', 'Controller/Component');

/**
 * Modelo de Tickets 
 */
class Ticket extends AppModel {
    /**
     * Nombre de Modelo
     * @var string
     */
    public $name = 'Ticket';
    
    /**
     * Nombre de la Tabla en la Base de Datos que utilizará el modelo.
     * @var string 
     */
    public $useTable = 'tickets';
     
    /**
     * Elimina todos los tickets con fecha anterior a now() 
     */
    private function purgeTickets() {
        $this->deleteAll('Ticket.expires <= now() LIMIT 1');
    }
    
    /**
     * Elimina el Ticket con el HASH = $hash
     * @param string $hash Hash 
     */
    public function deleteTicket($hash) {
        $this->deleteAll(array('hash' => $hash));
        $this->purgeTickets();
    }
    
    /**
     * Verifica si existe un Ticket.
     * Elimina todos los tickets con fecha anterior a now() 
     * 
     * @param string $hash Hash
     * @return array 
     */
    public function checkTicket($hash) {
        $this->purgeTickets();
        return $this->findByHash($hash);
    }
    
    /**
     * Obtiene la fecha en que expirará un ticket.
     * @param integer $days
     * @return date Fecha de Expiración 
     */
    public function getExpirationDate($days = 1) {
        $date = strftime('%c');
        $date = strtotime($date);
        $date += ($days * 24 * 60 * 60);
        $expired = date('Y-m-d H:i:s', $date);
        return $expired; 
    }
}
?>
