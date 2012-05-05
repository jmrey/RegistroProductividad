<div class="box form">
    <header>
        <h1 class="title btn-small"><?php echo $title_for_layout; ?></h1>
        <div class="btn-group right">
            <?php 
                /*$icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus'));
                echo $this->Html->link($icon_plus, array('controller' => 'articulos', 'action' => 'agregar'),
                    array('class' => 'btn btn-small', 'escape' => false));*/
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-list'));
                echo $this->Html->link($icon_plus . ' Resumen', array('action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>
    </header>
    <?php echo $this->Form->create('Patente', array('class' => 'form-inline container-fluid upper float-messages')); ?>
    <fieldset>
        <legend>Datos de Publicaci&oacute;n</legend>
        <div class="row-fluid">
            <div class="span12">
                <?php
                    echo $this->Form->input('titulo', array(
                        'label' => 'Nombre o Título:',
                        'class' => 'autocomplete',
                        'data-provide' => 'typehead',
                        'data-field' => 'titulo',
                        'data-source' => 'patentes'
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <?php
                    echo $this->Form->input('estado', array(
                        'label' => 'Estado de Patente',
                        'options' => $estado_patentes
                    ));
                ?>
            </div>
            <div class="span6">
                <?php
                    echo $this->Form->input('tipo', array(
                        'label' => 'Tipo de Patente',
                        'options' => $tipo_patentes
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <?php
                    echo $this->Form->input('tipo_numero', array(
                        'label' => 'Número de:',
                        'options' => array( 
                            'registro' => 'Registro',
                            'solicitud' => 'Solicitud'
                        )
                    ));
                ?>
            </div>
            <div class="span4 no-label">
                <?php
                    echo $this->Form->input('numero', array(
                        'label' => false,
                        'type' => 'number',
                        'class' => 'numeric'
                    ));
            ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <?php
                    echo $this->Form->input('fecha_concesion', array(
                        'label' => 'Fecha de Concesión:',
                        'type' => 'text',
                        'class' => 'calendar'
                    ));
                ?>
            </div>
            <div class="span6">
                <?php
                    echo $this->Form->input('fecha_presentación', array(
                        'label' => 'Fecha de Presentación:',
                        'type' => 'text',
                        'class' => 'calendar'
                    ));
                ?>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Datos de Autor</legend>
        <div class="row-fluid">
            <div class="span6">
                <?php 
                    echo $this->Form->input('tipo_titular', array(
                        'label' => 'Tipo de Participación:',
                        'options' => array(
                            'principal' => 'Autor Principal',
                            'coautor' => 'Coautor'
                        )
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <?php
                    echo $this->Form->input('titular', array(
                        'label' => 'Titular:'
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
            <?php echo $this->Form->checkbox('add_files', array('value' => 1)); ?>
            <span>Deseo agregar archivos, al guardar esta Patente.</span>
        </div>
    </fieldset>
    <div class="form-actions f-right">
        <div class="left">
            <?php echo $this->Session->flash(); ?>
        </div>
        <?php 
            echo $this->Form->submit('Guardar', array('class' => 'btn btn-success btn-large', 'div' => false));
            echo $this->Html->link('Cancelar', $referer, array('class' => 'btn btn-large'));
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>