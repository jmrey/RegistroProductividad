<html>
    <head>
        <style type="text/css">
            body {
                font-family: Helvetica, Arial, sans-serif;
                font-size: 9px;
                color: #333;
                padding: 0 20px;
            }
            h1 {
                font-size: 13px;
                font-weight: 100;
                line-height: 24px;
                position: absolute;
                top: -5px;
                text-shadow: -1px -1px 0 #EEE;
                white-space: nowrap;
            }
            #ipn-header {
                margin-bottom: 15px;
                margin-top: 5px;
                position: relative;
            }
            #ipn-header h1 {
                display: inline;
            }
            #ipn-header .main-menu-container {
                background-color: #007FD3;
                margin: 30px 90px 0 60px;
                padding: 0 15px 0 20px;
            }
            table {
                border:1px solid #000;
            }
        </style>
    </head>
    <body>
        <div class="container" id="ipn-header">
            <div class="logo-ipn" style="float: left; display: inline;">
                <img src="img/logo-IPN.gif" alt="Instituto Politecnico Nacional" style="height:40px">
                <h1>Instituto Polit&eacute;cnico Nacional</h1>
            </div>
            <div class="logo-escom" style="float: right; display: inline;">
                <h1>Escuela Superior de C&oacute;mputo</h1>
                <img src="img/escom.gif" alt="Instituto Politecnico Nacional" style="height:40px">
            </div>
            <div class="main-menu-container">
                <span>Registro de Productividad</span>
            </div>
        </div>
        <h1>Artículos</h1>
        <table>
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
                    <td><?php echo $art['anio_publicacion']; ?></td>
                    <td><?php echo $art['volumen']; ?></td>
                    <td><?php echo $art['paginas']; ?></td>
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