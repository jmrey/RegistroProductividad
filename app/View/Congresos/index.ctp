<div class="box content">
    <header>
        <h1 class="title btn-small">Libros</h1>
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
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus'));
                echo $this->Html->link($icon_plus, array('controller' => 'libros', 'action' => 'agregar'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus, array('controller' => 'users', 'action' => 'dashboard'),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>   
    </header>
    <table class="table table-condensed table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Detalles</th>
                <th>Título del Libro</th>
                <th>Tipo de Libro</th>
                <th>Año</th>
                <th>Editorial</th>
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
                        echo $this->Html->link('Ver', array('controller' => 'libros', 'action' => 'ver', $libro['id']),
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
</div>