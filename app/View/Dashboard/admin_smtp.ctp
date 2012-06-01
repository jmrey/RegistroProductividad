<div class="box content">
    <header class="admin">
        <h1 class="title btn-small">Configuración de Servidor SMTP</h1>
        <div class="btn-group right">
            <?php 
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-cog icon-white'));
                echo $this->Html->link($icon_plus . ' Ajustes', array( 'admin' => 1, 'action' => 'config'),
                    array('class' => 'btn btn-small btn-inverse', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-cog icon-white'));
                echo $this->Html->link($icon_plus . ' Administración', array( 'admin' => 1, 'action' => 'index'),
                    array('class' => 'btn btn-small btn-inverse', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('controller' => 'dashboard', 'action' => 'index', 'admin' => 0),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>
    </header>
    <div class="container form-inline">
        <div class="row">
            <div class="span12 input">
                <label>Correo Electrónico:</label>
                <?php echo $this->Html->link('Configurar Servidor SMTP', array('admin' => 1, 'action' => 'smtp'), array('class' => 'btn btn-primary')); ?>
            </div>
        </div>
    </div>
</div>
