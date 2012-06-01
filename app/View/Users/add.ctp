<div class="box form">
    <?php echo $this->Form->create('User', array('class' => 'form-inline big')); ?>
    <fieldset>
        <legend>Datos de Sesi&oacute;n</legend>
        <?php 
            echo $this->Form->input('username', array(
                'label' => 'Nombre de Usuario:'
            ));
            echo $this->Form->input('email', array(
                'label' => 'Correo Electrónico:',
                'type' => 'email'
            ));
            echo $this->Form->input('password', array(
                'label' => 'Contraseña:'
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
            echo $this->Form->input('escuela', array(
                'label' => 'Escuela:',
                'options' => $escuelas,
                'empty' => 'Elige una escuela:'
            ));
            
            $existsDeptos = isset($deptos) && !empty($deptos);
            echo $this->Form->input('depto', array(
                'label' => 'Departamento:',
                'options' => ($existsDeptos ? $deptos : array()),
                'empty' => 'Elige un departamento:',
                'div' => array(
                    'class' => 'input select deptos ' . ($existsDeptos ? '' : 'hidden')
                )
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
            echo $this->Form->submit('Registrar', array( 'class' => 'btn btn-success btn-large', 'div' => false));
            echo $this->Html->link('Limpiar', '/registrar', array('class' => 'btn btn-large'));
            echo $this->Html->link('Iniciar Sesión', '/iniciar_sesion');
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
