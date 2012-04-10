<div class="box form">
    <?php $c = $curso['Curso']; ?>
    <header>
        <h1 class="title btn-small">Cursos</h1>
        <div class="btn-group right">
            <?php 
                echo $this->Html->link('Editar', array('action' => 'editar', $c['id']),
                    array('class' => 'btn btn-small'));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus'));
                echo $this->Html->link($icon_plus . ' Nuevo Curso', array('action' => 'agregar'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-minus'));
                echo $this->Form->postLink($icon_plus . ' Borrar', array('action' => 'borrar', $c['id']),
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
            <h2>Datos de Curso</h2>
            <div class="row-fluid">
                <div class="span6">
                    <span class="label">Nombre:</span>
                    <?php echo $c['nombre']; ?>
                </div>
                <div class="span6">
                    <span class="label">Tipo de Curso:</span>
                    <?php echo $tipo_curso[$c['tipo_curso']]; ?>

                </div>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Año de Publicación:</span>
                    <?php echo $c['anio_publicacion']; ?>
                </div>
            </div>
        </div>
        <div>
            <h2>Datos de Autores</h2>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Total Autores:</span>
                    <?php echo 2;//$cong['num_autores']; ?>
                </div>
                <span class="info"><i class="icon-info-sign"></i> Se refire al n&uacute;mero de personas que participaron en la elaboraci&oacute;n del art&iacute;culo en cuesti&oacute;n.</span>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Posición Autor:</span>
                    <?php echo 3;//$cong['pos_autor']; ?>
                </div>
                <span class="info"><i class="icon-info-sign"></i> Se refire a la posici&oacute;n que ocupa el investigador en la lista de autores.</span>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <span class="label">Lista de Autores:</span>
                    <?php echo $c['lista_autores']; ?>
                </div>
            </div>
        </div>
        <div>
            <h2>Resumen</h2>
            <div class="row-fluid">
                <div class="span12 no-label">
                    <?php echo $c['resumen']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12 no-label">
                     <?php
                        echo $this->Html->link('Ver Archivos', '/'. $this->params['controller'] . '/' . $c['id'] . '/archivos', 
                            array('class' => 'btn btn-inverse btn-large')); 
                    ?>
                </div>
            </div>
        </div>
    </article>
</div>