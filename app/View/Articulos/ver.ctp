<div class="box content">
    <?php $art = $articulo['Articulo']; ?>
    <header>
        <h1 class="title btn-small"><?php echo $title_for_layout; ?></h1>
        <div class="btn-group right">
            <?php 
                echo $this->Html->link('Editar', array('controller' => 'articulos', 'action' => 'editar', $art['id']),
                    array('class' => 'btn btn-small'));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus'));
                echo $this->Html->link($icon_plus . ' Nuevo Artículo', array('action' => 'nuevo'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-minus'));
                echo $this->Form->postLink($icon_plus . ' Borrar', array('action' => 'borrar', $art['id']),
                    array('class' => 'btn btn-small', 'escape' => false), '¿Estás seguro?');
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-list'));
                echo $this->Html->link($icon_plus . ' Resumen', array('controller' => 'articulos', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
                
            ?>
        </div>
    </header>
    <?php echo $this->Session->flash(); ?>
    <article class="document">
        <div>
            <h2>Datos de Publicaci&oacute;n</h2>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Año de publicacion:</span>
                    <?php echo $art['anio_publicacion']; ?>
                </div>
                <div class="span4">
                    <span class="label">Volumen:</span>
                    <?php echo $art['volumen']; ?>
                </div>
                <div class="span4">
                    <span class="label">No. de Volumen:</span>
                    <?php echo $art['num_volumen']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <span class="label">Titulo de Artículo:</span>
                    <?php echo $art['titulo']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <span class="label">Tipo de Artículo:</span>
                    <?php 
                        $tipo_articulo = array( 
                            '0' => 'Científica',
                            '1' => 'ISI',
                            '2' => 'JCR',
                            '3' => 'Padrón CONACYT',
                            '4' => 'Institucional',
                            '5' => 'Difusión'
                        ); 
                    ?>
                    <?php echo $tipo_articulo[$art['tipo_articulo']]; ?>
                </div>
                <div class="span6">
                    <span class="label">Revista:</span>
                    <?php echo $art['titulo_revista']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <span class="label">Páginas:</span>
                    <?php echo $art['paginas']; ?>
                </div>
            </div>
        </div>
        <div>
            <h2>Datos de Autores</h2>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Total Autores:</span>
                    <?php echo $art['num_autores']; ?>
                </div>
                <span class="info"><i class="icon-info-sign"></i> Se refire al n&uacute;mero de personas que participaron en la elaboraci&oacute;n del art&iacute;culo en cuesti&oacute;n.</span>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Posición Autor:</span>
                    <?php echo $art['pos_autor']; ?>
                </div>
                <span class="info"><i class="icon-info-sign"></i> Se refire a la posici&oacute;n que ocupa el investigador en la lista de autores.</span>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <span class="label">Lista de Autores:</span>
                    <?php echo $art['lista_autores']; ?>
                </div>
            </div>
        </div>
        <div>
            <h2>Resumen</h2>
            <div class="row-fluid">
                <div class="span12 no-label">
                    <?php echo $art['resumen']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12 no-label">
                    <?php
                        echo $this->Html->link('Ver Archivos', '/'. $this->params['controller'] . '/' . $art['id'] . '/archivos', 
                            array('class' => 'btn btn-inverse btn-large'));
                    ?>
                </div>
            </div>
        </div>
    </article>
</div>