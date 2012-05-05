<div class="box profile">
    <header>
        <h1 class="title btn-small">Mis datos</h1>
        <div class="btn-group right">
            <?php 
                echo $this->Html->link('Modificar Datos', array('action' => 'edit'), 
                        array('class' => 'btn btn-small btn-primary'));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>
    </header>
    <div class="well">
        <h1>Datos de Sesi&oacute;n</h1>
        
        <div class="control-group">
            <span class="label">Nombre de usuario:</span><span><?php echo $authUser['username']; ?></span>
        </div>
        <div class="control-group">
            <span class="label">Correo Electr&oacute;nico:</span><span><?php echo $authUser['email']; ?></span>
        </div>
    </div>
    <div class="well">
        <h1>Datos de Perfil</h1>
        <div class="control-group">
            <span class="label">Nombre:</span><span><?php echo $authUser['nombre']; ?></span>
        </div>
        <div class="control-group">
            <span class="label">Departamento:</span><span><?php echo $deptos[$authUser['depto']]; ?></span>
        </div>
        <div class="control-group">
            <span class="label">N&uacute;mero de Empleado:</span><span><?php echo $authUser['no_empleado']; ?></span>
        </div>
    </div>
</div>
