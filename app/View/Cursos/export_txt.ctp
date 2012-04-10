<?php
    /*header("Content-Type: plain/text");
    header("Content-Disposition: Attachment; filename=mis-libros.txt");
    header("Pragma: no-cache");*/
    echo '#' . "---";
    echo 'Nombre de Curso' . "---";
    echo 'Tipo de Curso' . "---";
    echo 'Año' . "---";
    echo 'Autores' . "\n";   

    foreach ($cursos as $curso):
        $c = $curso['Curso'];
        echo $c['id'] . "---";
        echo $c['nombre'] . "---";
        echo $tipo_curso[$c['tipo_curso']] . "---";
        echo $c['anio_publicacion'] . "---";
        echo $c['lista_autores'] . "\n"; 
    endforeach;
?>

