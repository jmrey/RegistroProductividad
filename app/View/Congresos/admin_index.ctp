<div class="box content">
    <header class="admin">
        <h1 class="title btn-small">Todos los Congresos</h1>
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
                <th>Nombre de Congreso
                    <?php 
                        $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-retweet'));
                        echo $this->Paginator->sort('nombre', $icon_plus, array('escape' => false));
                    ?>
                </th>
                <th>Tipo de Congreso
                    <?php echo $this->Paginator->sort('tipo_congreso', $icon_plus, array('escape' => false)); ?>
                </th>
                <th>Año
                    <?php echo $this->Paginator->sort('anio_publicacion', $icon_plus, array('escape' => false)); ?>
                </th>
                <th>Autores
                    <?php echo $this->Paginator->sort('lista_autores', $icon_plus, array('escape' => false)); ?>
                </th>
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
    <?php echo $this->Paginator->numbers(); ?>
</div>