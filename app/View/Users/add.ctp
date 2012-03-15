<div class="box form">
    <?php echo $this->Form->create('User', array('class' => 'form-inline big')); ?>
    <fieldset>
        <legend>Datos de Sesi&oacute;n</legend>
        <?php 
            echo $this->Form->input('username', array(
                'label' => 'Nombre de Usuario:',
                'placeholder' => 'Nombre de Usuario'
            ));
            echo $this->Form->input('email', array(
                'label' => 'Correo Electrónico:',
                'type' => 'email',
                'placeholder' => 'Correo Electrónico'
            ));
            echo $this->Form->input('password', array(
                'label' => 'Contraseña:',
                'placeholder' => 'Contraseña'
            ));
        ?>
    </fieldset>
    <fieldset>
        <legend>Datos de Perfil</legend>
        <?php 
            echo $this->Form->input('nombre', array(
                'label' => 'Nombre completo:',
                'class' => 'capitalize',
                'placeholder' => 'Nombre Completo'
            ));
            echo $this->Form->input('depto', array(
                'label' => 'Depto. de Adscripción:',
                'placeholder' => 'Número de Empleado',
                'options' => $deptos
            ));
            echo $this->Form->input('no_empleado', array(
                'label' => 'Número de Empleado:',
                'type' => 'text',
                'placeholder' => 'Número de Empleado',
                'class' => 'numeric'
            ));
        ?>
    </fieldset>
    <div class="form-actions f-right">
        <div class="left">
            <?php echo $this->Session->flash(); ?>
        </div>
        <?php 
            echo $this->Form->end(array('label' => 'Registrar', 'class' => 'btn btn-success btn-large', 'div' => false));
            echo $this->Form->button('Limpiar', array('type' => 'reset', 'class' => 'btn btn-large'));
            echo $this->Html->link('Iniciar Sesión', '/login');
        ?>
    </div>
</div>
