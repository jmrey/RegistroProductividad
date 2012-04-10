<div class="box content">
    <header>
        <h1 class="title btn-small">Congresos</h1>
        <div class="btn-group right">
            <a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#exportar">
                Guardar como
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <?php 
                    echo $this->Html->link('Texto', array(
                        'action' => 'exportar',
                        'txt'
                        ), array());
                    ?>
                </li>
                <li>
                    <?php 
                    echo $this->Html->link('PDF', array(
                        'action' => 'exportar',
                        'pdf'
                        ), array());
                    ?>
                </li>
                <li>
                    <?php 
                    echo $this->Html->link('XML', array(
                        'action' => 'exportar',
                        'xml'
                        ), array());
                    ?>
                </li>
            </ul>
            <?php 
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus'));
                echo $this->Html->link($icon_plus . ' Nuevo Congreso', array('action' => 'nuevo'),
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
                <th>Nombre de Congreso</th>
                <th>Tipo de Congreso</th>
                <th>Año</th>
                <th>Autores</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($congresos as $congreso):
                    $c = $congreso['Congreso'];
            ?>
            <tr>
                <td><?php echo $c['id']; ?></td>
                <td>
                    <?php
                        echo $this->Html->link('Ver', $c['id'],
                                array());
                    ?>
                </td>
                <td><?php echo $c['nombre']; ?></td>
                <td><?php echo $tipo_congreso[$c['tipo_congreso']]; ?></td>
                <td><?php echo $c['anio_publicacion']; ?></td>
                <td><?php echo $c['lista_autores']; ?></td>
            </tr>
            <?php
                endforeach;
            ?>
        </tbody>
    </table>
</div>