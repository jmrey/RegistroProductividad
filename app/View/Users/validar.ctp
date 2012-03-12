<div class="box content">
    <?php $message = $this->Session->flash(); ?>
    <span class="label">Usuario:</span><span><?php echo $username; ?></span>
    <span class="label">Email:</span><span><?php echo $email; ?></span>
    <span class="label">Clave:</span><span><?php echo $keycode; ?></span>
    <?php echo $this->Form->postLink('Click para validar.', array('controller' => 'users', 'action' => 'validar', $keycode)); ?>
    <?php 
        if ($message):
            echo $message;
        endif;
    ?>
</div>