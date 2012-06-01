<div class="box content">
    <header class="admin">
        <h1 class="title btn-small">Configuración</h1>
        <div class="btn-group right">
            <?php 
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-cog icon-white'));
                echo $this->Html->link($icon_plus . ' Administración', array('controller' => 'dashboard', 'action' => 'index', 'admin' => 1),
                    array('class' => 'btn btn-small btn-inverse', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('controller' => 'dashboard', 'action' => 'index', 'admin' => 0),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>
    </header>
    <div class="container form-inline">
        <div class="row">
            <div class="span12 input">
                <label>Contenidos activados:</label>
                <div class="btn-group" data-toggle="buttons-checkbox">
                    <button class="btn <?php echo ($contenido_articulos)?'active':''; ?>" data-property="contenido_articulos">Artículos</button>
                    <button class="btn <?php echo ($contenido_libros)?'active':''; ?>" data-property="contenido_libros">Libros</button>
                    <button class="btn <?php echo ($contenido_capitulos)?'active':''; ?>" data-property="contenido_capitulos">Capítulos</button>
                    <button class="btn <?php echo ($contenido_patentes)?'active':''; ?>" data-property="contenido_patentes">Patentes</button>
                    <button class="btn <?php echo ($contenido_tesis)?'active':''; ?>" data-property="contenido_tesis">Tesis</button>
                    <button class="btn <?php echo ($contenido_congresos)?'active':''; ?>" data-property="contenido_congresos">Congresos</button>
                    <button class="btn <?php echo ($contenido_cursos)?'active':''; ?>" data-property="contenido_cursos">Cursos</button>
                    <button class="btn <?php echo ($contenido_derechos)?'active':''; ?>" data-property="contenido_derechos">Derechos de Autor</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12 input">
                <label>Verificar cuentas de correo eléctronico de Usuarios:</label>
                <button class="btn <?php echo ($validate_accounts)?'active':''; ?>" data-toggle="button" data-property="validate_accounts"></button>
            </div>
        </div>
        <div class="row">
            <div class="span12 input">
                <label>Forzar descarga de reportes:</label>
                <button class="btn <?php echo ($forzar_descargas)?'active':''; ?>" data-toggle="button" data-property="forzar_descargas"></button>
            </div>
        </div>
        <div class="row">
            <div class="span12 input">
                <label>Correo Electrónico:</label>
                <?php echo $this->Html->link('Configurar Servidor SMTP', array('admin' => 1, 'action' => 'smtp'), array('class' => 'btn btn-primary')); ?>
            </div>
        </div>
    </div>
</div>
