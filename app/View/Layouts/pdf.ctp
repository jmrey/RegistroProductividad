<?php
    App::import('Vendor', 'dompdf', array('file' => 'dompdf/dompdf_config.inc.php'));
    spl_autoload_register('DOMPDF_autoload'); 
    //require_once(APP . 'Vendor' . DS . 'dompdf' . DS . 'dompdf_config.inc.php');
    $dompdf = new DOMPDF();
    $dompdf->load_html(utf8_decode($content_for_layout), Configure::read('App.encoding'));
    $dompdf->render();
    echo $dompdf->output();
?>