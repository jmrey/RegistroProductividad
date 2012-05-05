<div class="box form">
    <header>
        <h1 class="title btn-small">Capítulos</h1>
        <div class="btn-group right">
            <?php 
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-list'));
                echo $this->Html->link($icon_plus . ' Resumen', array('controller' => 'capitulos', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>
    </header>
    <?php echo $this->Form->create('Capitulo', array('class' => 'form-inline container-fluid upper float-messages')); ?>
    <fieldset>
        <legend>Datos de Publicaci&oacute;n</legend>
        <div class="row-fluid">
            <div class="span8">
                <?php
                    echo $this->Form->input('titulo_capitulo', array(
                        'label' => 'Título Capítulo:',
                        'type' => 'text'
                    ));
                ?>
            </div>
            <div class="span4">
                <?php 
                    $currentYear = date('Y');
                    echo $this->Form->input('anio_publicacion', array(
                        'label' => 'Año Publicación:',
                        'type' => 'number',
                        'class' => 'numeric',
                        'min' => '1950',
                        'max' => $currentYear,
                        'value' => $currentYear
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <?php
                    echo $this->Form->input('titulo_libro', array(
                        'label' => 'Titulo de Libro:',
                        'class' => 'autocomplete',
                        'data-provide' => 'typehead',
                        'data-source' => 'capitulos',
                        'data-field' => 'titulo_libro'
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <?php
                    echo $this->Form->input('editores', array(
                        'label' => 'Editores:',
                        'class' => 'autocomplete',
                        'data-provide' => 'typehead',
                        'data-source' => 'capitulos',
                        'data-field' => 'editores'
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <?php
                    echo $this->Form->input('editorial', array(
                        'label' => 'Editorial:',
                        'class' => 'autocomplete',
                        'data-provide' => 'typehead',
                        'data-source' => 'capitulos',
                        'data-field' => 'editorial'
                    ));
                ?>
            </div>
            <div class="span2">
                <?php
                    echo $this->Form->input('volumen', array(
                        'label' => 'Volumen:',
                        'type' => 'number',
                        'class' => 'numeric'
                    ));
                ?>
            </div>
            <div class="span2">
                <?php
                    echo $this->Form->input('num_paginas', array(
                        'label' => 'Págs:',
                        'type' => 'number',
                        'class' => 'numeric'
                    ));
                ?>
            </div>
            <div class="span2">
                <?php
                    echo $this->Form->input('num_citas', array(
                        'label' => 'No. Citas:',
                        'type' => 'number',
                        'class' => 'numeric'
                    ));
                ?>
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
            <span>Deseo agregar archivos, al guardar este Capítulo.</span>
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