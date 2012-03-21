<?php
    /*header("Content-Type: plain/text");
    header("Content-Disposition: Attachment; filename=mis-articulos.txt");
    header("Pragma: no-cache");*/
    echo '#' . "---";
    echo 'Título Capítulo' . "---";
    echo 'Título Libro' . "---";
    echo 'Año' . "---";
    echo 'Editorial' . "\n";    

    foreach ($capitulos as $c):
        $cap = $c['Capitulo'];
        echo $cap['id'] . "---";
        echo $cap['titulo_capitulo'] . "---";
        echo $cap['titulo_libro'] . "---";
        echo $cap['anio_publicacion'] . "---";
        echo $cap['editorial'] . "\n"; 
    endforeach;
?>

