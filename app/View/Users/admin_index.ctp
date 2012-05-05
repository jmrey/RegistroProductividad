<div class="box content">
    <header class="admin">
        <h1 class="title btn-small">Usuarios</h1>
        <div class="btn-group right">
            <?php
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-cog icon-white'));
                echo $this->Html->link($icon_plus . ' Administración', array('admin' => 1, 'controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small btn-inverse', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('admin' => 0, 'controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>
    </header>
    <table class="table table-condensed table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th><?php echo $this->Paginator->sort('nombre', 'Nombre'); ?></th>
                <th><?php echo $this->Paginator->sort('username', 'Username'); ?></th>
                <th><?php echo $this->Paginator->sort('email', 'Email'); ?></th>
                <th><?php echo $this->Paginator->sort('depto', 'Depto.'); ?></th>
                <th><?php echo $this->Paginator->sort('no_empleado', 'No. Empleado'); ?></th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($users as $user):
                    $u = $user['User'];
            ?>
            <tr>
                <td><?php echo $u['id']; ?></td>
                <td>
                    <?php echo $u['nombre']; ?>
                    
                    <?php if ($u['status'] == 2) { ?>   
                        <span class="label label-important right">admin</span>
                    <?php } ?>
                </td>
                <td><?php echo $u['username']; ?></td>
                <td><?php echo $u['email']; ?></td>
                <td><?php echo $deptos[$u['depto']]; ?></td>
                <td><?php echo $u['no_empleado']; ?></td>
                <td><?php echo $this->Html->link('Ver Perfil', array('admin' => 1, 'action' => 'perfil', $u['id'])); ?></td>
            </tr>
            <?php
                endforeach;
            ?>
        </tbody>
    </table>
</div>