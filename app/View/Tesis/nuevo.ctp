<div class="box form">
    <header>
        <h1 class="title btn-small">Tesis</h1>
        <div class="btn-group right">
            <?php 
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-list'));
                echo $this->Html->link($icon_plus . ' Resumen', array('controller' => 'tesis', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>
    </header>
    <?php echo $this->Form->create('Tesis', array('class' => 'form-inline container-fluid float-messages')); ?>
    <fieldset>
        <legend>Datos de Tesis</legend>
        <div class="row-fluid">
            <div class="span6">
                <?php 
                    echo $this->Form->input('nombre', array(
                        'label' => 'Nombre:',
                        'type' => 'text'
                    ));
                ?>
            </div>
            <div class="span6">
                <?php 
                    echo $this->Form->input('tipo_tesis', array(
                        'label' => 'Tipo de Tesis:',
                        'options' => $tipo_tesis
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4">
                <?php
                    $currentYear = date('Y');
                    echo $this->Form->input('anio_publicacion', array(
                        'label' => 'Año Publicación:',
                        'type' => 'number',
                        'class' => 'numeric',
                        'min' => 1950,
                        'max' => $currentYear,
                        'value' => $currentYear
                    ));
                ?>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Datos de Autores</legend>
        <div class="row-fluid">
            <div class="span3">
                <?php 
                    echo $this->Form->input('num_autores', array(
                        'label' => 'Total Autores:',
                        'type' => 'number',
                        'class' => 'numeric',
                        'min' => '1',
                        'max' => '5'
                    ));
                ?>
            </div>
            <?php echo $this->element('info_message', array(
                'message' => $message_autors['total'],
                'name' => 'message_total_autor'
            )); ?>
        </div>
        <div class="row-fluid">
            <div class="span3">
                <?php 
                    echo $this->Form->input('pos_autor', array(
                        'label' => 'Posición Autor:',
                        'type' => 'number',
                        'class' => 'numeric',
                        'min' => '1',
                        'max' => '5'
                    ));
            ?>
            </div>
            <?php echo $this->element('info_message', array(
                'message' => $message_autors['pos'],
                'name' => 'message_pos_autor'
            )); ?>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <?php
                    echo $this->Form->input('lista_autores', array(
                        'label' => 'Lista Autores:',
                        'type' => 'textarea'
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <?php
                    echo $this->Form->input('lista_directores', array(
                        'label' => 'Lista Directores:',
                        'type' => 'textarea'
                    ));
                ?>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Resumen<span id="resumeCounter" class="counterText"></span></legend>
        <div class="row-fluid">
            <div class="span12 no-label">
                <?php
                    echo $this->Form->input('resumen', array(
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
            echo $this->Form->submit('Guardar', array('class' => 'btn btn-success btn-large', 'div' => false));
            echo $this->Form->button('Cancelar', array('type' => 'reset', 'class' => 'btn btn-large'));
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>