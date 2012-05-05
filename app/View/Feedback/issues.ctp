<div class="box form">
    <div>
        <div>
            <span class="label">URL:</span><span><?php echo $error['url']; ?></span>
        </div>
        <div>
            <span class="label">Email:</span><span><?php echo $error['user_email']; ?></span>
        </div>
        <div>
            <span class="label">Detalles:</span><p><?php echo $error['resumen']; ?></p>
        </div>
    </div>
    <div class="form-actions f-right">
        <div class="left">
            <?php echo $this->Session->flash(); ?>
        </div>
        <?php 
            if ($authUser) {
                echo $this->Html->link('Escritorio', array('controller' => 'dashboard', 'action' => 'index'),
                        array('class' => 'btn btn-large btn-primary'));
            }
            $referer = $this->Session->read('App.referer');
            echo $this->Html->link('Regresar', $referer, array('class' => 'btn btn-large'));
        ?>
    </div>
</div>