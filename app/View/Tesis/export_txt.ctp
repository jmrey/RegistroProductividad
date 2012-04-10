<?php
    /*header("Content-Type: plain/text");
    header("Content-Disposition: Attachment; filename=mis-articulos.txt");
    header("Pragma: no-cache");*/
    echo '#' . "---";
    echo 'Título del Artículo' . "---";
    echo 'Año' . "---";
    echo 'Vol.' . "---";
    echo 'Páginas' . "---";
    echo 'Autores' . "---";
    echo 'Título de la Revista' . "\n";    

    foreach ($articulos as $a):
        $art = $a['Articulo'];
        echo $art['id'] . "---";
        echo $art['titulo'] . "---";
        echo $art['anio_publicacion'] . "---";
        echo $art['volumen'] . "---";
        echo $art['paginas'] . "---";
        echo $art['lista_autores'] . "---";
        echo $art['titulo_revista'] . "\n"; 
    endforeach;
?>

