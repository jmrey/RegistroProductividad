<div class="box form">
    <header>
        <h1 class="title btn-small">Libros</h1>
        <div class="btn-group right">
            <?php 
                echo $this->Html->link('Ver', array('controller' => 'libros', 'action' => 'ver', $this->request->data['Libro']['id']),
                    array('class' => 'btn btn-small'));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus'));
                echo $this->Html->link($icon_plus, array('controller' => 'libros', 'action' => 'agregar'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus, array('controller' => 'users', 'action' => 'dashboard'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-list'));
                echo $this->Html->link($icon_plus, array('controller' => 'libros', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-minus'));
                echo $this->Html->link($icon_plus, array('controller' => 'libros', 'action' => 'agregar'),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>
    </header>
    <?php echo $this->Form->create('Libro', array('class' => 'form-inline container-fluid float-messages')); ?>
    <fieldset>
        <legend>Datos de Libro</legend>
        <div class="row-fluid">
            <div class="span6">
                <?php 
                    echo $this->Form->input('isbn', array(
                        'label' => 'Numero de ISBN:',
                        'type' => 'text',
                        'class' => 'numeric'
                    ));
                ?>
            </div>
            <div class="span6">
                <?php 
                    echo $this->Form->input('tipo_libro', array(
                        'label' => 'Identificador Libro:',
                        'options' => array( 
                            '0' => 'Autorizado',
                            '1' => 'Compilación',
                            '2' => 'Editado',
                            '3' => 'Publicado',
                            '4' => 'Traducido'
                        )
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <?php
                    echo $this->Form->input('titulo', array(
                        'label' => 'Titulo de Libro:'
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <?php
                    echo $this->Form->input('editorial', array(
                        'label' => 'Editorial:'
                    ));
                ?>
            </div>
            <div class="span6">
                <?php
                    echo $this->Form->input('edicion', array(
                        'label' => 'Edición:'
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4">
                <?php
                    echo $this->Form->input('anio_publicacion', array(
                        'label' => 'Año Publicación:',
                        'type' => 'number',
                        'class' => 'numeric',
                        'min' => '1',
                        'max' => '2012'
                    ));
                ?>
            </div>
            <div class="span4">
                <?php
                    echo $this->Form->input('volumen', array(
                        'label' => 'Volumen:',
                        'type' => 'number',
                        'class' => 'numeric',
                        'min' => '1'
                    ));
                ?>
            </div>
            <div class="span4">
                <?php 
                    echo $this->Form->input('num_paginas', array(
                        'label' => 'No. Páginas:',
                        'type' => 'number',
                        'class' => 'numeric',
                        'min' => '1'
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4">
                <?php
                    echo $this->Form->input('tiraje', array(
                        'label' => 'Tiraje:',
                        'type' => 'number',
                        'class' => 'numeric',
                        'min' => '1'
                    ));
                ?>
            </div>
            <div class="span8">
                <?php 
                    echo $this->Form->input('idioma', array(
                        'label' => 'Idioma:',
                        'type' => 'text'
                    ));
                ?>
            </div>
            
        </div>
        <div class="row-fluid">
            <div class="span4">
                <?php
                    echo $this->Form->input('palabra_clave1', array(
                        'label' => 'Palabra Clave 1:'
                    ));
                ?>
            </div>
            <div class="span4">
                <?php
                    echo $this->Form->input('palabra_clave2', array(
                        'label' => 'Palabra Clave 2:'
                    ));
                ?>
            </div>
            <div class="span4">
                <?php
                    echo $this->Form->input('palabra_clave3', array(
                        'label' => 'Palabra Clave 3:'
                    ));
                ?>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Datos de Autores</legend>
        <div class="row-fluid">
            <div class="span4">
                <?php 
                    echo $this->Form->input('num_autores', array(
                        'label' => 'Total Autores:',
                        'class' => 'number'
                    ));
                ?>
            </div>
            <span class="info"><i class="icon-info-sign"></i> Se refire al n&uacute;mero de personas que participaron en la elaboraci&oacute;n del art&iacute;culo en cuesti&oacute;n.</span>
        </div>
        <div class="row-fluid">
            <div class="span4">
                <?php 
                    echo $this->Form->input('pos_autor', array(
                        'label' => 'Posición Autor:',
                        'class' => 'number'
                    ));
            ?>
            </div>
            <span class="info"><i class="icon-info-sign"></i> Se refire a la posici&oacute;n que ocupa el investigador en la lista de autores.</span>
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
        </div>
    </fieldset>
    <div class="form-actions f-right">
        <div class="left">
            <?php echo $this->Session->flash(); ?>
        </div>
        <?php 
            echo $this->Form->end(array('label' => 'Guardar', 'class' => 'btn btn-success btn-large', 'div' => false));
            echo $this->Form->button('Cancelar', array('type' => 'reset', 'class' => 'btn btn-large'));
        ?>
    </div>
</div>