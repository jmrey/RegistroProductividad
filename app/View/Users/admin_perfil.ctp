<div class="box profile">
    <header class="admin">
        <h1 class="title btn-small">Perfil de <?php echo $user['nombre']; ?></h1>
        <div class="btn-group right">
            <?php
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home icon-white'));
                echo $this->Html->link($icon_plus . ' Administración', array('controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small btn-inverse', 'escape' => false));
            ?>
        </div>
    </header>
    <div class="well">
        <h1>Datos de Sesi&oacute;n</h1>
        <div class="control-group">
            <span class="label">Nombre de usuario:</span><span><?php echo $user['username']; ?></span>
        </div>
        <div class="control-group">
            <span class="label">Correo Electr&oacute;nico:</span><span><?php echo $user['email']; ?></span>
        </div>
    </div>
    <div class="well">
        <h1>Datos de Perfil</h1>
        <div class="control-group">
            <span class="label">Nombre:</span><span><?php echo $user['nombre']; ?></span>
        </div>
        <div class="control-group">
            <span class="label">Departamento:</span><span><?php echo $deptos[$user['depto']]; ?></span>
        </div>
        <div class="control-group">
            <span class="label">N&uacute;mero de Empleado:</span><span><?php echo $user['no_empleado']; ?></span>
        </div>
    </div>
    <div class="form-actions f-right">
        <div class="left">
            <?php echo $this->Session->flash(); ?>
        </div>
        <?php 
            if ($user['status'] != 2) {
                $str = 'Cambiar rol de <strong>' . $user['username'] . '</strong> como Administrador';
                echo $this->Form->postLink($str, 
                    array('admin' => 1, 'action' => 'upgrade', $user['id'], $user['keycode']), 
                    array('class' => 'btn btn-large btn-danger', 'escape' => false),
                    '¿Realmente quieres que ' . $user['nombre'] .' sea Adminsitrador?');
            } else {
                $str = '<strong>' . $user['username'] . '</strong> ya es Administrador';
                echo $this->Html->tag('span', $str, 
                        array('class' => 'btn btn-large btn-danger disabled', 'escape' => false));
            }
            echo $this->Html->link('Regresar', array('admin' => 1, 'action' => 'index'), array('class' => 'btn btn-large'));
        ?>
    </div>
</div>
