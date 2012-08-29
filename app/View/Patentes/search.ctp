<div class="box content">
    <header>
        <h1 class="title btn-small"><?php echo $title_for_layout; ?></h1>
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
                echo $this->Html->link($icon_plus . ' Nueva Patente', array('action' => 'nuevo'),
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
                <th>Título de Patente</th>
                <th>Estado</th>
                <th>Tipo</th>
                <th>Número</th>
                <th>Titular</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $count = 1;
                foreach ($patentes as $p):
                    $pat = $p['Patente'];
            ?>
            <tr>
                <td><?php echo $count++; //$pat['id']; ?></td>
                <td>
                    <?php
                        echo $this->Html->link('Ver', $pat['id'],
                                array());
                    ?>
                </td>
                <td><?php echo $pat['titulo']; ?></td>
                <td><?php echo $estado_patentes[$pat['estado']]; ?></td>
                <td><?php echo $tipo_patentes[$pat['tipo']]; ?></td>
                <td><?php echo $pat['numero']; ?></td>
                <td><?php echo $pat['titular']; ?></td>
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
