<?php
    /*header("Content-Type: plain/text");
    header("Content-Disposition: Attachment; filename=mis-libros.txt");
    header("Pragma: no-cache");*/
    echo '#' . "---";
    echo 'Nombre de Congreso' . "---";
    echo 'Tipo de Congreso' . "---";
    echo 'Año' . "---";
    echo 'Autores' . "\n";   

    foreach ($congresos as $cong):
        $c = $cong['Congreso'];
        echo $c['id'] . "---";
        echo $c['nombre'] . "---";
        echo $tipo_congreso[$c['tipo_congreso']] . "---";
        echo $c['anio_publicacion'] . "---";
        echo $c['lista_autores'] . "\n"; 
    endforeach;
?>

