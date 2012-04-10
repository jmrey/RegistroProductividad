<?php
class TicketmasterComponent extends Component {
    private $hours = 24;
    
    public function getExpirationDate() {
        $date = strftime('%c');
        $date = strtotime($date);
        $date += ($this->hours * 60 * 60);
        $expired = date('Y-m-d H:i:s', $date);
        return $expired; 
    }
    
    function checkTicket($hash){
        $this->purgeTickets();
        $ret = false;
        $tick = $this->controller->Ticket->findByHash($hash);

        if(empty($tick)){
            //no more ticket			
        } else {
            $ret=$tick;
        }
        return $ret;
    }

}
?>