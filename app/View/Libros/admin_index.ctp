<div class="box content">
    <header class="admin">
        <h1 class="title btn-small">Todos los Libros</h1>
        <div class="btn-group right">
            <a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#exportar">
                Guardar como
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <?php 
                    echo $this->Html->link('Texto', array(
                        'controller' => 'libros',
                        'action' => 'exportar',
                        'txt'
                        ), array());
                    ?>
                </li>
                <li>
                    <?php 
                    echo $this->Html->link('PDF', array(
                        'controller' => 'libros',
                        'action' => 'exportar',
                        'pdf'
                        ), array());
                    ?>
                </li>
                <li>
                    <?php 
                    echo $this->Html->link('XML', array(
                        'controller' => 'libros',
                        'action' => 'exportar',
                        'xml'
                        ), array());
                    ?>
                </li>
            </ul>
            <?php 
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('admin' => 0, 'controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-cog icon-white'));
                echo $this->Html->link($icon_plus . ' Administración', array('admin' => 1, 'controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small btn-inverse', 'escape' => false));
            ?>
        </div>   
    </header>
    <?php echo $this->Session->flash(); ?>
    <table class="table table-condensed table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Detalles</th>
                <th>Título del Libro
                    <?php 
                        $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-retweet'));
                        echo $this->Paginator->sort('titulo', $icon_plus, array('escape' => false));
                    ?>
                </th>
                <th>Tipo de Libro
                    <?php echo $this->Paginator->sort('tipo_libro', $icon_plus, array('escape' => false)); ?>
                </th>
                <th>Año
                    <?php echo $this->Paginator->sort('anio_publicacion', $icon_plus, array('escape' => false)); ?>
                </th>
                <th>Editorial
                    <?php echo $this->Paginator->sort('editorial', $icon_plus, array('escape' => false)); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($libros as $l):
                    $libro = $l['Libro'];
            ?>
            <tr>
                <td><?php echo $libro['id']; ?></td>
                <td>
                    <?php
                        echo $this->Html->link('Ver', $libro['id'],
                                array());
                    ?>
                </td>
                <td><?php echo $libro['titulo']; ?></td>
                <td><?php echo $tipo_libros[$libro['tipo_libro']]; ?></td>
                <td><?php echo $libro['anio_publicacion']; ?></td>
                <td><?php echo $libro['editorial']; ?></td>
            </tr>
            <?php
                endforeach;
            ?>
        </tbody>
    </table>
    <?php echo $this->Paginator->numbers(); ?>
</div>