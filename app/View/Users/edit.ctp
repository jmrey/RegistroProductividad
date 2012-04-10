<div class="box form">
    <header>
        <h1 class="title btn-small">Modificar Datos</h1>
        <div class="btn-group right">
            <?php
                echo $this->Html->link('Perfil', array('controller' => 'users', 'action' => 'profile'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>
    </header>
    <?php echo $this->Form->create('User', array('action' => 'edit','class' => 'form-inline big')); ?>
    <fieldset>
        <legend>Datos de Sesi&oacute;n</legend>
        <?php 
            echo $this->Html->link('Cambiar contraseña', array('action' => 'nuevopassword', $authUser['keycode']), 
                        array('class' => 'btn btn-primary btn-small right'));
            echo $this->Form->input('username', array(
                'label' => 'Nombre de Usuario:'
            ));
            echo $this->Form->input('email', array(
                'label' => 'Correo Electrónico:',
                'type' => 'email'
            ));
        ?>
    </fieldset>
    <fieldset>
        <legend>Datos de Perfil</legend>
        <?php 
            echo $this->Form->input('nombre', array(
                'label' => 'Nombre completo:',
                'class' => 'capitalize'
            ));
            echo $this->Form->input('depto', array(
                'label' => 'Depto. de Adscripción:',
                'options' => $deptos
            ));
            echo $this->Form->input('no_empleado', array(
                'label' => 'Número de Empleado:',
                'type' => 'text',
                'class' => 'numeric'
            ));
        ?>
    </fieldset>
    <div class="form-actions f-right">
        <div class="left">
            <?php echo $this->Session->flash(); ?>
        </div>
        <?php 
            echo $this->Form->submit('Guardar', array('class' => 'btn btn-success btn-large', 'div' => false));
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
