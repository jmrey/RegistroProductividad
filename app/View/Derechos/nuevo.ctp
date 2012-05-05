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
    <?php echo $this->Form->create('Derecho', array('class' => 'form-inline container-fluid upper float-messages')); ?>
    <fieldset>
        <legend>Datos de Publicaci&oacute;n</legend>
        <div class="row-fluid">
            <div class="span12">
                <?php
                    echo $this->Form->input('titulo', array(
                        'label' => 'Título:',
                        'class' => 'autocomplete',
                        'data-provide' => 'typehead',
                        'data-field' => 'titulo',
                        'data-source' => 'derechos'
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <?php
                    echo $this->Form->input('fecha_solicitud', array(
                        'label' => 'Fecha de Solicitud:',
                        'type' => 'text',
                        'class' => 'calendar'
                    ));
                ?>
            </div>
            <div class="span6">
                <?php
                    echo $this->Form->input('numero_tramite', array(
                        'label' => 'Número de Trámite:',
                        'type' => 'text',
                        'class' => 'numeric'
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <?php
                    echo $this->Form->input('fecha_registro', array(
                        'label' => 'Fecha de Registro:',
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
                    echo $this->Form->input('usuario', array(
                        'label' => 'Beneficiario/Usuario:'
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <?php
                    echo $this->Form->input('entidad', array(
                        'label' => 'Entidad:',
                        'options' => array(
                            'publica' => 'Pública',
                            'privada' => 'Privada',
                            'social' => 'Sector Social'
                        )
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
            <span>Deseo agregar archivos, al guardar este Derecho de Autor.</span>
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