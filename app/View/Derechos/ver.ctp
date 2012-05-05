<div class="box content">
    <?php $d = $derecho['Derecho']; ?>
    <header>
        <h1 class="title btn-small"><?php echo $title_for_layout; ?></h1>
        <div class="btn-group right">
            <?php 
                echo $this->Html->link('Editar', array('action' => 'editar', $d['id']),
                    array('class' => 'btn btn-small'));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus'));
                echo $this->Html->link($icon_plus . ' Nuevo Artículo', array('action' => 'nuevo'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-minus'));
                echo $this->Form->postLink($icon_plus . ' Borrar', array('action' => 'borrar', $d['id']),
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
                    <span class="label">Título:</span>
                    <?php echo $d['titulo']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <span class="label">Fecha de Solicitud:</span>
                    <?php echo $d['fecha_solicitud']; ?>
                </div>
                <div class="span6">
                    <span class="label">Número de Trámite:</span>
                    <?php echo $d['numero_tramite']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <span class="label">Fecha de Registro</span>
                    <?php echo $d['fecha_registro']; ?>
                </div>
            </div>
        </div>
        <div>
            <h2>Datos de Autor</h2>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Beneficiario/Usuario</span>
                    <?php echo $d['usuario']; ?>
                </div>
                
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <span class="label">Entidad:</span>
                    <?php echo $d['entidad']; ?>
                </div>
            </div>
        </div>
        <div>
            <h2>Resumen</h2>
            <div class="row-fluid">
                <div class="span12 no-label">
                    <?php echo $d['resumen']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12 no-label">
                    <?php
                        echo $this->Html->link('Ver Archivos', '/'. $this->params['controller'] . '/' . $d['id'] . '/archivos', 
                            array('class' => 'btn btn-inverse btn-large'));
                    ?>
                </div>
            </div>
        </div>
    </article>
</div>