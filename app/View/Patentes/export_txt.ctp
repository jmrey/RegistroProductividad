<?php
    /*header("Content-Type: plain/text");
    header("Content-Disposition: Attachment; filename=mis-articulos.txt");
    header("Pragma: no-cache");*/
    echo '#' . "---";
    echo 'Título de Patente' . "---";
    echo 'Estado de Patente' . "---";
    echo 'Tipo de Patente' . "---";
    echo 'Numero' . "---";
    echo 'Titular' . "\n";    

    foreach ($patentes as $patente):
        $p = $patente['Patente'];
        echo $p['id'] . "---";
        echo $p['titulo'] . "---";
        echo $estado_patentes[$p['estado']] . "---";
        echo $tipo_patentes[$p['tipo']] . "---";
        echo $p['numero'] . "---";
        echo $p['titular'] . "\n"; 
    endforeach;
?>

