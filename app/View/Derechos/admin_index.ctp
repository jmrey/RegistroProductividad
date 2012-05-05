<div class="box content">
    <header class="admin">
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
                <th>Título de Derecho
                    <?php
                        $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-retweet'));
                        echo $this->Paginator->sort('titulo', $icon_plus, array('escape' => false));
                    ?>
                </th>
                <th>Número de Trámite
                    <?php echo $this->Paginator->sort('numero_tramite', $icon_plus, array('escape' => false)); ?>
                </th>
                <th>Usuario/Beneficiario
                    <?php echo $this->Paginator->sort('usuario', $icon_plus, array('escape' => false)); ?>
                </th>
                <th>Entidad
                    <?php echo $this->Paginator->sort('entidad', $icon_plus, array('escape' => false)); ?>
                </th>
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