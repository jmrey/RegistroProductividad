<div class="box form">
    <?php $cap = $capitulo['Capitulo']; ?>
    <header>
        <h1 class="title btn-small">Capítulos</h1>
        <div class="btn-group right">
        <?php 
            echo $this->Html->link('Editar', array('action' => 'editar', $cap['id']),
                    array('class' => 'btn btn-small'));
            $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus'));
            echo $this->Html->link($icon_plus . ' Nuevo Capítulo', array('action' => 'nuevo'),
                array('class' => 'btn btn-small', 'escape' => false));
            $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-minus'));
            echo $this->Form->postLink($icon_plus . ' Borrar', array('action' => 'borrar', $cap['id']),
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
    <article class="document">
        <div>
            <h2>Datos de Publicaci&oacute;n</h2>
            <div class="row-fluid">
                <div class="span8">
                    <span class="label">Titulo Capítulo:</span>
                    <?php echo $cap['titulo_capitulo']; ?>
                </div>
                <div class="span4">
                    <span class="label">Año de publicacion:</span>
                    <?php echo $cap['anio_publicacion']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <span class="label">Título Libro:</span>
                    <?php echo $cap['titulo_libro']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <span class="label">Editores:</span>
                    <?php echo $cap['editores']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <span class="label">Editorial:</span>
                    <?php echo $cap['editorial']; ?>
                </div>
                <div class="span2">
                    <span class="label">Volumen:</span>
                    <?php echo $cap['volumen']; ?>
                </div>
                <div class="span2">
                    <span class="label">No. de Págs:</span>
                    <?php echo $cap['num_paginas']; ?>
                </div>
                <div class="span2">
                    <span class="label">No. de Citas:</span>
                    <?php echo $cap['num_citas']; ?>
                </div>
        </div>
        <div>
            <h2>Datos de Autores</h2>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Total Autores:</span>
                    <?php echo $cap['num_autores']; ?>
                </div>
                <span class="info"><i class="icon-info-sign"></i> Se refire al n&uacute;mero de personas que participaron en la elaboraci&oacute;n del art&iacute;culo en cuesti&oacute;n.</span>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Posición Autor:</span>
                    <?php echo $cap['pos_autor']; ?>
                </div>
                <span class="info"><i class="icon-info-sign"></i> Se refire a la posici&oacute;n que ocupa el investigador en la lista de autores.</span>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <span class="label">Lista de Autores:</span>
                    <?php echo $cap['lista_autores']; ?>
                </div>
            </div>
        </div>
        <div>
            <h2>Resumen</h2>
            <div class="row-fluid">
                <div class="span12 no-label">
                    <?php echo $cap['resumen']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12 no-label">
                    <?php
                        echo $this->Html->link('Ver Archivos', '/'. $this->params['controller'] . '/' . $cap['id'] . '/archivos', 
                            array('class' => 'btn btn-inverse btn-large'));
                    ?>
                </div>
            </div>
        </div>
    </article>
</div>