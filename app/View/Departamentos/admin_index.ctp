<div class="box content">
    <header class="admin">
        <h1 class="title btn-small">Departamentos</h1>
        <div class="btn-group right">
            <?php
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus icon-white'));
                echo $this->Html->link($icon_plus . ' Nuevo Departamento', array('admin' => 1, 'controller' => 'departamentos', 'action' => 'nuevo'),
                    array('class' => 'btn btn-small btn-success', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-book icon-white'));
                echo $this->Html->link($icon_plus . ' Escuelas', array('admin' => 1, 'controller' => 'escuelas', 'action' => 'index'),
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
                <th><?php echo $this->Paginator->sort('escuela_id', 'Escuela'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($deptos as $depto):
                    $d = $depto['Departamento'];
                    $e = $depto['Escuela'];
            ?>
            <tr>
                <td><?php echo $d['id']; ?></td>
                <td><?php echo $d['nombre']; ?></td>
                <td><?php echo $e['nombre']; ?></td>
            </tr>
            <?php
                endforeach;
            ?>
        </tbody>
    </table>
</div>