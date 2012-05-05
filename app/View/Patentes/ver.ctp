<div class="box content">
    <?php $p = $patente['Patente']; ?>
    <header>
        <h1 class="title btn-small"><?php echo $title_for_layout; ?></h1>
        <div class="btn-group right">
            <?php 
                echo $this->Html->link('Editar', array('action' => 'editar', $p['id']),
                    array('class' => 'btn btn-small'));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus'));
                echo $this->Html->link($icon_plus . ' Nuevo Artículo', array('action' => 'nuevo'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-minus'));
                echo $this->Form->postLink($icon_plus . ' Borrar', array('action' => 'borrar', $p['id']),
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
                <div class="span12">
                    <span class="label">Nombre o Título:</span>
                    <?php echo $p['titulo']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <span class="label">Estado de Patente:</span>
                    <?php echo $estado_patentes[$p['estado']]; ?>
                </div>
                <div class="span6">
                    <span class="label">Tipo de Patente:</span>
                    <?php echo $tipo_patentes[$p['tipo']]; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <span class="label">Número de <?php echo $p['tipo_numero']; ?></span>
                    <?php echo $p['numero']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <span class="label">Fecha de Concesión:</span>
                    <?php echo $p['fecha_concesion']; ?>
                </div>
                <div class="span6">
                    <span class="label">Fecha de Presentacióñ:</span>
                    <?php echo $p['fecha_presentacion']; ?>
                </div>
            </div>
        </div>
        <div>
            <h2>Datos de Autor</h2>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Tipo de Participación:</span>
                    <?php echo $p['tipo_titular']; ?>
                </div>
                
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <span class="label">Titular:</span>
                    <?php echo $p['titular']; ?>
                </div>
            </div>
        </div>
        <div>
            <h2>Resumen</h2>
            <div class="row-fluid">
                <div class="span12 no-label">
                    <?php echo $p['resumen']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12 no-label">
                    <?php
                        echo $this->Html->link('Ver Archivos', '/'. $this->params['controller'] . '/' . $p['id'] . '/archivos', 
                            array('class' => 'btn btn-inverse btn-large'));
                    ?>
                </div>
            </div>
        </div>
    </article>
</div>