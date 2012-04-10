<?php
    /*header("Content-Type: plain/text");
    header("Content-Disposition: Attachment; filename=mis-articulos.txt");
    header("Pragma: no-cache");*/
    echo '#' . "---";
    echo 'Nombre de Tesis' . "---";
    echo 'Año' . "---";
    echo 'Tipo de Tesis' . "---";
    echo 'Autores' . "\n";    

    foreach ($tesis as $content):
        $t = $content['Tesis'];
        echo $t['id'] . "---";
        echo $t['nombre'] . "---";
        echo $t['anio_publicacion'] . "---";
        echo $tipo_tesis[$t['tipo_tesis']] . "---";
        echo $t['lista_autores'] . "\n"; 
    endforeach;
?>

