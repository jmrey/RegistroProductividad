<div class="box form">
    <?php $cong = $congreso['Congreso']; ?>
    <header>
        <h1 class="title btn-small">Congresos</h1>
        <div class="btn-group right">
            <?php 
                echo $this->Html->link('Editar', array('action' => 'editar', $cong['id']),
                    array('class' => 'btn btn-small'));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus'));
                echo $this->Html->link($icon_plus . ' Nuevo Congreso', array('action' => 'nuevo'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-minus'));
                echo $this->Form->postLink($icon_plus . ' Borrar', array('action' => 'borrar', $cong['id']),
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
            <h2>Datos de Libro</h2>
            <div class="row-fluid">
                <div class="span6">
                    <span class="label">Nombre:</span>
                    <?php echo $cong['nombre']; ?>
                </div>
                <div class="span6">
                    <span class="label">Tipo de Congreso:</span>
                    <?php echo $tipo_congreso[$cong['tipo_congreso']]; ?>

                </div>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Año de Publicación:</span>
                    <?php echo $cong['anio_publicacion']; ?>
                </div>
            </div>
        </div>
        <div>
            <h2>Datos de Autores</h2>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Total Autores:</span>
                    <?php echo $cong['num_autores']; ?>
                </div>
                <span class="info"><i class="icon-info-sign"></i> Se refire al n&uacute;mero de personas que participaron en la elaboraci&oacute;n del art&iacute;culo en cuesti&oacute;n.</span>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Posición Autor:</span>
                    <?php echo $cong['pos_autor']; ?>
                </div>
                <span class="info"><i class="icon-info-sign"></i> Se refire a la posici&oacute;n que ocupa el investigador en la lista de autores.</span>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <span class="label">Lista de Autores:</span>
                    <?php echo $cong['lista_autores']; ?>
                </div>
            </div>
        </div>
        <div>
            <h2>Resumen</h2>
            <div class="row-fluid">
                <div class="span12 no-label">
                    <?php echo $cong['resumen']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12 no-label">
                    <?php
                        echo $this->Html->link('Ver Archivos', '/'. $this->params['controller'] . '/' . $cong['id'] . '/archivos', 
                            array('class' => 'btn btn-inverse btn-large'));
                    ?>
                </div>
            </div>
        </div>
    </article>
</div>