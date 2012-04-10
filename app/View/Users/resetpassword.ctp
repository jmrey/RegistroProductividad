<div class="box form">
    <?php    
        echo $this->Session->flash('auth', array(
            'params' => array('type' => 'warning'),
            'element' => 'alert'
        ));
    ?>
    <?php echo $this->Form->create('User', array('action' => 'resetpassword','class' => 'form-inline big')); ?>
    <fieldset>
        <p class="alert alert-info">El sistema enviará un email con las indicaciones para recuperar tu constraseña.</p>
        <legend>Recuperar Contraseña</legend>
        <?php 
            echo $this->Form->input('email', array(
                'label' => 'Correo electrónico:'
            ));
        ?>
    </fieldset>
    <div class="form-actions f-right">
        <div class="left">
            <?php echo $this->Session->flash(); ?>
        </div>
        <?php 
            echo $this->Form->submit('Enviar', array('class' => 'btn btn-success btn-large', 'div' => false));
            echo $this->Html->link('Registrarme', '/registrar');
            echo $this->Html->link('Iniciar Sesión', '/iniciar_sesion');
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
