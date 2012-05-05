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
                <th>Título del Artículo
                    <?php
                        $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-retweet'));
                        echo $this->Paginator->sort('titulo', $icon_plus, array('escape' => false));
                    ?>
                </th>
                <th>Año
                    <?php echo $this->Paginator->sort('anio_publicacion', $icon_plus, array('escape' => false)); ?>
                </th>
                <th>Vol.</th>
                <th>Páginas</th>
                <th>Autores
                    <?php echo $this->Paginator->sort('lista_autores', $icon_plus, array('escape' => false)); ?>
                </th>
                <th>Título de la Revista
                    <?php echo $this->Paginator->sort('titulo_revista', $icon_plus, array('escape' => false)); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                $count = 1;
                foreach ($articulos as $a):
                    $art = $a['Articulo'];
            ?>
            <tr>
                <td><?php echo $count++; //$art['id']; ?></td>
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
    <?php 
        if (isset($this->Paginator)) {
            echo $this->Paginator->numbers(); 
        }
    ?>
</div>