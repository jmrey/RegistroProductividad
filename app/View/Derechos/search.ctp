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
                echo $this->Html->link($icon_plus . ' Nuevo Derecho de Autor', array('action' => 'nuevo'),
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
                <th>Título de Derecho</th>
                <th>Número de Trámite</th>
                <th>Usuario/Beneficiario</th>
                <th>Entidad</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $count = 1;
                foreach ($derechos as $d):
                    $der = $d['Derecho'];
            ?>
            <tr>
                <td><?php echo $count++; //$der['id']; ?></td>
                <td>
                    <?php
                        echo $this->Html->link('Ver', $der['id'],
                                array());
                    ?>
                </td>
                <td><?php echo $der['titulo']; ?></td>
                <td><?php echo $der['numero_tramite']; ?></td>
                <td><?php echo $der['usuario']; ?></td>
                <td><?php echo $der['entidad']; ?></td>
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
