<div class="box form">
    <header>
        <h1 class="title btn-small">Artículos</h1>
        <div class="btn-group right">
            <?php 
                $id = $this->request->data['Articulo']['id'];
                echo $this->Html->link('Ver', $id, array('class' => 'btn btn-small'));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus'));
                echo $this->Html->link($icon_plus . ' Nuevo Artículo', array('action' => 'nuevo'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-minus'));
                echo $this->Form->postLink($icon_plus . ' Borrar', array('action' => 'borrar', $id),
                    array('class' => 'btn btn-small', 'escape' => false), '¿Estás seguro?');
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-list'));
                echo $this->Html->link($icon_plus . ' Resumen', array('action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>
    </header>
    <?php echo $this->Form->create('Articulo', array('class' => 'form-inline container-fluid upper float-messages')); ?>
    <fieldset>
        <legend>Datos de Publicaci&oacute;n</legend>
        <div class="row-fluid">
            <div class="span4">
                <?php
                    echo $this->Form->input('anio_publicacion', array(
                        'label' => 'Año de publicación:',
                        'type' => 'number',
                        'class' => 'numeric',
                        'min' => '1950',
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
                    echo $this->Form->input('num_volumen', array(
                        'label' => 'No. de Volumen:',
                        'type' => 'number',
                        'class' => 'numeric',
                        'min' => '1'
                    ));
                ?>  
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <?php
                    echo $this->Form->input('titulo', array(
                      'label' => 'Titulo de Artículo:'
                    ));
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <?php
                    echo $this->Form->input('tipo_articulo', array(
                        'label' => 'Tipo de Artículo:',
                        'options' => array( 
                            '0' => 'Científica',
                            '1' => 'ISI',
                            '2' => 'JCR',
                            '3' => 'Padrón CONACYT',
                            '4' => 'Institucional',
                            '5' => 'Difusión'
                        )
                    ));
                ?>
            </div>
            <div class="span6">
                <?php
                    echo $this->Form->input('titulo_revista', array(
                        'label' => 'Revista:'
                    ));
            ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <?php
                    echo $this->Form->input('paginas', array(
                        'label' => 'Páginas:'
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
                        'min' => '1'
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
                        'min' => '1'
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
        </div>
    </fieldset>
    <div class="form-actions f-right">
        <div class="left">
            <?php echo $this->Session->flash(); ?>
        </div>
        <?php 
            echo $this->Html->link('Ver Archivos', '/'. $this->params['controller'] . '/' . $id . '/archivos', 
                array('class' => 'btn btn-inverse btn-large'));
            echo $this->Form->submit('Guardar', array('class' => 'btn btn-success btn-large', 'div' => false));
            echo $this->Html->link('Cancelar', $referer, array('class' => 'btn btn-large'));
        ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>