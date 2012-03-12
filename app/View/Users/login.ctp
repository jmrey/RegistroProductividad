<div class="box form">
    <?php    
        echo $this->Session->flash('auth', array(
            'params' => array('type' => 'warning'),
            'element' => 'alert'
        ));
    ?>
    <?php echo $this->Form->create('User', array('class' => 'form-inline big')); ?>
    <fieldset>
        <legend>Datos de Sesi&oacute;n</legend>
        <?php 
            echo $this->Form->input('username', array(
                'label' => 'Nombre de Usuario:',
                'placeholder' => 'Nombre de Usuario'
            ));
            echo $this->Form->input('password', array(
                'label' => 'Contraseña:',
                'placeholder' => 'Contraseña'
            ));
        ?>
    </fieldset>
    <div class="form-actions f-right">
        <div class="left">
            <?php echo $this->Session->flash(); ?>
        </div>
        <?php 
            echo $this->Form->end(array('label' => 'Entrar', 'class' => 'btn btn-success btn-large', 'div' => false));
            echo $this->Html->link('Registrarme', '/signup');
            echo $this->Html->link('Recuperar contraseña', '/recover');
        ?>
    </div>
</div>
