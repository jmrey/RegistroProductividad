<div class="box content">
    <header class="admin">
        <h1 class="title btn-small">Escuelas</h1>
        <div class="btn-group right">
            <?php
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus icon-white'));
                echo $this->Html->link($icon_plus . ' Nueva Escuela', array('admin' => 1, 'controller' => 'escuelas', 'action' => 'nuevo'),
                    array('class' => 'btn btn-small btn-success', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-book icon-white'));
                echo $this->Html->link($icon_plus . ' Departamentos', array('admin' => 1, 'controller' => 'departamentos', 'action' => 'index'),
                    array('class' => 'btn btn-small btn-success', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-cog icon-white'));
                echo $this->Html->link($icon_plus . ' Administración', array('admin' => 1, 'controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small btn-inverse', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('admin' => 0, 'controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>
    </header>
    <?php echo $this->Session->flash(); ?>
    <table class="table table-condensed table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th><?php echo $this->Paginator->sort('nombre', 'Nombre'); ?></th>
                <th><?php echo $this->Paginator->sort('acronimo', 'Acrónimo'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($escuelas as $escuela):
                    $u = $escuela['Escuela'];
            ?>
            <tr>
                <td><?php echo $u['id']; ?></td>
                <td><?php echo $u['nombre']; ?></td>
                <td><?php echo $u['acronimo']; ?></td>
            </tr>
            <?php
                endforeach;
            ?>
        </tbody>
    </table>
</div>