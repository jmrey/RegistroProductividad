<div class="box content">
    <header>
        <h1 class="title btn-small">Artículos</h1>
        <div class="btn-group right">
                <a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#exportar">
                    Guardar como
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <?php 
                        echo $this->Html->link('Texto', array(
                            'controller' => 'articulos',
                            'action' => 'exportar',
                            'txt'
                            ), array());
                        ?>
                    </li>
                    <li>
                        <?php 
                        echo $this->Html->link('PDF', array(
                            'controller' => 'articulos',
                            'action' => 'exportar',
                            'pdf'
                            ), array());
                        ?>
                    </li>
                    <li>
                        <?php 
                        echo $this->Html->link('XML', array(
                            'controller' => 'articulos',
                            'action' => 'exportar',
                            'xml'
                            ), array());
                        ?>
                    </li>
                </ul>
            <?php
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus'));
                echo $this->Html->link($icon_plus . ' Nuevo Artículo', array('controller' => 'articulos', 'action' => 'nuevo'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>
    </header>
    <?php echo $this->Session->flash(); ?>
    <table class="table table-condensed table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Detalles</th>
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
                foreach ($articulos as $a):
                    $art = $a['Articulo'];
            ?>
            <tr>
                <td><?php echo $art['id']; ?></td>
                <td>
                    <?php
                        echo $this->Html->link('Ver', $art['id'],
                                array());
                    ?>
                </td>
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
</div>