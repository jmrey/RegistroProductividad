<html>
    <head>
        <!--<link rel="stylesheet" type="text/css" href="css/bootstrap.css">-->
        <style type="text/css">
            body {
                font-family: Helvetica, Arial, sans-serif;
                font-size: 9px;
                color: #333;
            }
            h1 {
                font-size: 12px;
                padding: 0 10px 0 0;
            }
            span.title {
                font-family: Georgia, Helvetica, Arial, sans-serif;
                font-size: 16px;
            }
            .right {
                text-align: right;
            }
            .center {
                text-align: center;
            }
            table.sample {
                border-width: 1px;
                border-spacing: 0px;
                border-style: solid;
                border-color: black;
                border-collapse: collapse;
                background-color: white;
                width:100%;
            }
            table.sample th {
                border-width: 1px;
                padding: 3px;
                border-style: solid;
                border-color: black;
                background-color: white;
            }
            table.sample td {
                border-width: 1px;
                padding: 2px;
                border-style: solid;
                border-color: black;
                background-color: white;
            }
        </style>
    </head>
    <body marginwidth="0" marginheight="0" style="padding:10px;">
        <?php echo $this->element('pdf_header', array(
            'title' => 'Artículos'
        )); ?>
        <table class="sample">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Título del Artículo</th>
                    <th>Año</th>
                    <th>Vol.</th>
                    <th>Páginas</th>
                    <th>Autores</th>
                    <th>Título de la Revista</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $count = 0;
                    foreach ($articulos as $a):
                        $art = $a['Articulo'];
                ?>
                <tr>
                    <td><?php echo ++$count; ?></td>
                    <td><?php echo $art['titulo']; ?></td>
                    <td class="center"><?php echo $art['anio_publicacion']; ?></td>
                    <td class="center"><?php echo $art['volumen']; ?></td>
                    <td class="center"><?php echo $art['paginas']; ?></td>
                    <td><?php echo $art['lista_autores']; ?></td>
                    <td><?php echo $art['titulo_revista']; ?></td>
                </tr>
                <?php
                    endforeach;
                ?>
            </tbody>
        </table>
    </body>
</html>