<html>
    <?php $imgWidth = 40; ?>
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
            'title' => 'Congresos'
        )); ?>
        <table class="sample">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre de Congreso</th>
                    <th>Tipo de Congreso</th>
                    <th>Año</th>
                    <th>Autores</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $count = 0;
                    foreach ($congresos as $congreso):
                        $c = $congreso['Congreso'];
                ?>
                <tr>
                    <td><?php echo ++$count; ?></td>
                    <td><?php echo $c['nombre']; ?></td>
                    <td><?php echo $tipo_congreso[$c['tipo_congreso']]; ?></td>
                    <td class="center"><?php echo $c['anio_publicacion']; ?></td>
                    <td><?php echo $c['lista_autores']; ?></td>
                </tr>
                <?php
                    endforeach;
                ?>
            </tbody>
        </table>
    </body>
</html>