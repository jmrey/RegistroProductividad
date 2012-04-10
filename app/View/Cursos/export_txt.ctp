<?php
    /*header("Content-Type: plain/text");
    header("Content-Disposition: Attachment; filename=mis-libros.txt");
    header("Pragma: no-cache");*/
    echo '#' . "---";
    echo 'Título del Libro' . "---";
    echo 'Tipo de Libro' . "---";
    echo 'Año' . "---";
    echo 'Editorial' . "\n";   

    foreach ($libros as $l):
        $libro = $l['Libro'];
        echo $libro['id'] . "---";
        echo $libro['titulo'] . "---";
        echo $libro['tipo_libro'] . "---";
        echo $libro['anio_publicacion'] . "---";
        echo $libro['editorial'] . "\n"; 
    endforeach;
?>

