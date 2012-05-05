<div class="box form">
    <?php if ($authUser) { ?>
    <header>
        <h1 class="title btn-small">Hola
            <?php 
                $name = implode(' ', array_splice(explode(' ', $authUser['nombre'], 3), 0, 2));
                echo $this->Html->link($name, array( 'controller' => 'users', 'action' => 'profile'), 
                    array('class' => 'capitalize')); 
            ?>.
        </h1>
        <div class="btn-group right">
            <?php      
                echo $this->Html->link('Ver mis datos', array('controller' => 'users', 'action' => 'profile'), 
                    array('class' => 'btn btn-success btn-small'));
                if ($isAdmin) {
                    $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-cog icon-white'));
                    echo $this->Html->link($icon_plus . ' Administración', 
                        array('controller' => 'dashboard', 'action' => 'index', 'admin' => 0),
                        array('class' => 'btn btn-small btn-inverse', 'escape' => false));
                }

            ?>
        </div>
    </header>
    <?php } ?>
    <?php echo $this->Form->create(null, array('class' => 'form-inline container-fluid big')); ?>
    <fieldset>
        <legend>Información</legend>
        <?php 
            echo $this->Form->input('nombre', array(
                'label' => 'Nombre de Usuario:',
                'placeholder' => 'Nombre de Usuario',
                'value' => AuthComponent::user('username')
            ));
            echo $this->Form->input('email', array(
                'label' => 'Correo Electrónico:',
                'placeholder' => 'Correo Electrónico',
                'value' => AuthComponent::user('email')
            ));
        ?>
    </fieldset>
    <fieldset>
        <legend>Detalles<span id="resumeCounter" class="counterText"></span></legend>
        <div class="row-fluid">
            <div class="span12 no-label">
                <?php
                    echo $this->Form->input('detalles', array(
                        'label' => false,
                        'type' => 'textarea',
                        'id' => 'resumeTextarea'
                    ));
                ?>
            </div>
        </div>
    </fieldset>
    <div class="form-actions f-right">
        <div class="left">
            <?php echo $this->Session->flash(); ?>
        </div>
        <?php 
            echo $this->Form->submit('Enviar', array( 'class' => 'btn btn-success btn-large', 'div' => false));
            $referer = $this->Session->read('App.referer');
            echo $this->Html->link('Regresar', $referer);
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>