<div class="box content">
    <header>
        <h1 class="title btn-small">Configuración</h1>
        <div class="btn-group right">
            <?php 
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus, array('controller' => 'users', 'action' => 'dashboard', 'admin' => 0),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>
    </header>
    <div class="container form-inline">
        <div class="row">
            <div class="span12 input">
                <label>Contenidos activados:</label>
                <div class="btn-group" data-toggle="buttons-checkbox">
                    <button class="btn <?php echo ($content_articles)?'active':''; ?>" data-property="content_articles">Artículos</button>
                    <button class="btn <?php echo ($content_books)?'active':''; ?>" data-property="content_books">Libros</button>
                    <button class="btn <?php echo ($content_chapters)?'active':''; ?>" data-property="content_chapters">Capítulos</button>
                    <button class="btn <?php echo ($content_patents)?'active':''; ?>" data-property="content_patents">Patentes</button>
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
                <button class="btn <?php echo ($force_downloads)?'active':''; ?>" data-toggle="button" data-property="force_downloads"></button>
            </div>
        </div>
    </div>
</div>