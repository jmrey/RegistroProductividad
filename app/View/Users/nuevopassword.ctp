<div class="box form">
    <?php if ($authUser) { ?>
    <header>
        <h1 class="title btn-small">Cambiar Contraseña</h1>
        <div class="btn-group right">
            <?php 
                echo $this->Html->link('Perfil', array('controller' => 'users', 'action' => 'perfil'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>
    </header>
    <?php } ?>
    <?php 
        if (isset($userFound) && $userFound == false) {
            echo $this->Session->flash();
        } else { 
            echo $this->Form->create('User', array('url' => array('action' => 'nuevopassword', $this->request->data['User']['keycode']),
                'class' => 'form-inline big')); 
            echo $this->element('alert', array(
                'type' => 'alert-info',
                'message' => 'Ingresa tu nueva contraseña.'
            )); 
    ?>
    <fieldset>
        <?php 
            echo $this->Form->input('password', array(
                'label' => 'Contraseña:'
            ));
            echo $this->Form->input('confirm_password', array(
                'label' => 'Repite contraseña:',
                'type' => 'password'
            ));
        ?>
    </fieldset>
    <div class="form-actions f-right">
        <?php 
            echo $this->Form->submit('Aceptar', array('class' => 'btn btn-success btn-large', 'div' => false));
        ?>
    </div>
    <?php echo $this->Form->end(); 
        }
    ?>
</div>
