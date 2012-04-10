<div class="box form">
    <?php echo $this->Form->create('Contenido', array('class' => 'form-inline big')); ?>
    <fieldset>
        <legend>Datos de Contenido</legend>
        <?php 
            echo $this->Form->input('name', array(
                'label' => 'Nombre:'
            ));
            echo $this->Form->input('title', array(
                'label' => 'Título:'
            ));
            echo $this->Form->input('content', array(
                'type' => 'textarea',
                'label' => 'Contenido:'
            ));
            echo $this->Form->input('type', array(
                'label' => 'Tipo:',
                'options' => array(
                    'page' => 'Página',
                    'text' => 'Texto',
                    'property' => 'Propiedad'
                )
            ));
        ?>
    </fieldset>
    <div class="form-actions f-right">
        <div class="left">
            <?php echo $this->Session->flash(); ?>
        </div>
        <?php 
            echo $this->Form->submit('Guardar', array('class' => 'btn btn-success btn-large', 'div' => false));
            echo $this->Form->button('Limpiar', array('type' => 'reset', 'class' => 'btn btn-large'));
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
