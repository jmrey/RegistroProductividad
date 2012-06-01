<div class="box form">
    <header class="admin">
        <h1 class="title btn-small">Nueva Escuela</h1>
        <div class="btn-group right">
            <?php 
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-book icon-white'));
                echo $this->Html->link($icon_plus . ' Escuelas', array('admin' => 1,'action' => 'index'),
                    array('class' => 'btn btn-small btn-success', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-cog icon-white'));
                echo $this->Html->link($icon_plus . ' Administración', array('admin' => 1,'controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small btn-inverse', 'escape' => false));
            ?>
        </div>
    </header>
    <?php echo $this->Form->create('Escuela', array('class' => 'form-inline big upper')); ?>
    <fieldset>
        <legend>Datos de Escuela</legend>
        <?php 
            echo $this->Form->input('nombre', array(
                'label' => 'Nombre de la Escuela:'
            ));
            echo $this->Form->input('acronimo', array(
                'label' => 'Acronimo:'
            ));
        ?>
    </fieldset>
    <div class="form-actions f-right">
        <div class="left">
            <?php echo $this->Session->flash(); ?>
        </div>
        <?php 
            echo $this->Form->submit('Agregar', array( 'class' => 'btn btn-success btn-large', 'div' => false));
            echo $this->Html->link('Cancelar', $referer, array('class' => 'btn btn-large'));
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
