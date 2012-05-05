<div class="box dashboard">
    <header>
        <h1 class="title btn-small">Hola
            <?php 
                $name = implode(' ', array_splice(explode(' ', $authUser['nombre'], 3), 0, 2));
                echo $this->Html->link($name, array( 'controller' => 'users', 'action' => 'perfil'), 
                    array('class' => 'capitalize')); 
            ?>.
        </h1>
        <div class="btn-group right">
            <?php      
                echo $this->Html->link('Ver mis datos', array('controller' => 'users', 'action' => 'perfil'), 
                    array('class' => 'btn btn-success btn-small'));
                if ($isAdmin) {
                    $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-cog icon-white'));
                    echo $this->Html->link($icon_plus . ' Administración', 
                        array('controller' => 'dashboard', 'action' => 'index', 'admin' => $isAdmin),
                        array('class' => 'btn btn-small btn-inverse', 'escape' => false));
                }

            ?>
        </div>
    </header>
    <?php    
        echo $this->Session->flash('auth', array(
            'params' => array('type' => 'warning'),
            'element' => 'alert'
        ));
    ?>
    <div class="pane">
        <?php echo $this->Session->flash(); ?>
        <?php 
            $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus'));
            $icon_list = $this->Html->tag('i', '', array('class' => 'icon-list'));
            if ($this->Session->read('App.settings.contenido_articulos')) {
        ?>
            <div class="btn-group">
                <?php 
                    echo $this->Html->link($icon_list . ' Artículos', array('controller' => 'articulos', 'action' => 'index'),
                        array('class' => 'btn btn-large', 'escape' => false));
                    echo $this->Html->link($icon_plus . ' Nuevo Artículo', array('controller' => 'articulos', 'action' => 'nuevo'),
                        array('class' => 'btn btn-large', 'escape' => false));
                    echo $this->Form->create('Articulo', array('action' => 'search', 'type' => 'get', 'class' => 'form-inline btn btn-large')); 
                    echo $this->Form->input('q', array('label' => false, 'placeholder' => 'Buscar en Artículos...')); 
                    echo $this->Form->end(array('label' => 'Buscar', 'class' => 'search-btn', 'div' => false));
                ?>
            </div>
        <?php } ?>
        <?php if ($this->Session->read('App.settings.contenido_libros')) {?>
            <div class="btn-group">
                <?php 
                    echo $this->Html->link($icon_list . ' Libros', array('controller' => 'libros', 'action' => 'index'),
                        array('class' => 'btn btn-large', 'escape' => false));
                    echo $this->Html->link($icon_plus . ' Nuevo Libro', array('controller' => 'libros', 'action' => 'nuevo'),
                        array('class' => 'btn btn-large', 'escape' => false));
                    echo $this->Form->create('Libro', array('action' => 'search', 'type' => 'get', 'class' => 'form-inline btn btn-large')); 
                    echo $this->Form->input('q', array('label' => false, 'placeholder' => 'Buscar en Libros...')); 
                    echo $this->Form->end(array('label' => 'Buscar', 'class' => 'search-btn', 'div' => false)); 
                ?>
                
            </div>
        <?php } ?>
        <?php if ($this->Session->read('App.settings.contenido_capitulos')) {?>
            <div class="btn-group">
                <?php 
                    echo $this->Html->link($icon_list . ' Capítulos Libros', array('controller' => 'capitulos', 'action' => 'index'),
                        array('class' => 'btn btn-large', 'escape' => false));
                    echo $this->Html->link($icon_plus . ' Nuevo Capítulo', array('controller' => 'capitulos', 'action' => 'nuevo'),
                        array('class' => 'btn btn-large', 'escape' => false));
                    echo $this->Form->create('Capitulo', array('action' => 'search', 'type' => 'get', 'class' => 'form-inline btn btn-large')); 
                    echo $this->Form->input('q', array('label' => false, 'placeholder' => 'Buscar en Capítulos...')); 
                    echo $this->Form->end(array('label' => 'Buscar', 'class' => 'search-btn', 'div' => false));
                ?>
            </div>
        <?php } ?>
        <?php if ($this->Session->read('App.settings.contenido_patentes')) {?>
            <div class="btn-group">
                <?php 
                    echo $this->Html->link($icon_list . ' Patentes', array('controller' => 'patentes', 'action' => 'index'),
                        array('class' => 'btn btn-large', 'escape' => false));
                    echo $this->Html->link($icon_plus . ' Nueva Patente', array('controller' => 'patentes', 'action' => 'nuevo'),
                        array('class' => 'btn btn-large', 'escape' => false));
                    echo $this->Form->create('Patente', array('action' => 'search', 'type' => 'get', 'class' => 'form-inline btn btn-large')); 
                    echo $this->Form->input('q', array('label' => false,  'placeholder' => 'Buscar en Patentes...')); 
                    echo $this->Form->end(array('label' => 'Buscar', 'class' => 'search-btn', 'div' => false));
                ?>
                <!--<a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#">
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <?php 
                            echo $this->Html->link($icon_plus . ' Nuevo', array('controller' => 'patentes', 'action' => 'nuevo'),
                                array('escape' => false)); 
                        ?>
                    </li>
                    <li>
                        <?php 
                            echo $this->Html->link($icon_plus . ' Nuevo', array('controller' => 'patentes', 'action' => 'nuevo'),
                                array('escape' => false)); 
                        ?>
                    </li>
                </ul>-->
            </div>
        <?php } ?>
        <?php if ($this->Session->read('App.settings.contenido_tesis')) {?>
            <div class="btn-group">
                <?php 
                    echo $this->Html->link($icon_list . ' Tesis', array('controller' => 'tesis', 'action' => 'index'),
                        array('class' => 'btn btn-large', 'escape' => false));
                    echo $this->Html->link($icon_plus . ' Nueva Tesis', array('controller' => 'tesis', 'action' => 'nuevo'),
                        array('class' => 'btn btn-large', 'escape' => false));
                    echo $this->Form->create('Tesis', array('url' => array('controller' => 'tesis', 'action' => 'search'), 'type' => 'get', 'class' => 'form-inline btn btn-large')); 
                    echo $this->Form->input('q', array('label' => false, 'placeholder' => 'Buscar Tesis...')); 
                    echo $this->Form->end(array('label' => 'Buscar', 'class' => 'search-btn', 'div' => false)); 
                ?>
                
            </div>
        <?php } ?>
        <?php if ($this->Session->read('App.settings.contenido_congresos')) {?>
            <div class="btn-group">
                <?php 
                    echo $this->Html->link($icon_list . ' Congresos', array('controller' => 'congresos', 'action' => 'index'),
                        array('class' => 'btn btn-large', 'escape' => false));
                    echo $this->Html->link($icon_plus . ' Nuevo Congreso', array('controller' => 'congresos', 'action' => 'nuevo'),
                        array('class' => 'btn btn-large', 'escape' => false));
                    echo $this->Form->create('Congreso', array('action' => 'search', 'type' => 'get', 'class' => 'form-inline btn btn-large')); 
                    echo $this->Form->input('q', array('label' => false, 'placeholder' => 'Buscar Congresos...')); 
                    echo $this->Form->end(array('label' => 'Buscar', 'class' => 'search-btn', 'div' => false)); 
                ?>
                
            </div>
        <?php } ?>
        <?php if ($this->Session->read('App.settings.contenido_cursos')) {?>
            <div class="btn-group">
                <?php 
                    echo $this->Html->link($icon_list . ' Cursos', array('controller' => 'cursos', 'action' => 'index'),
                        array('class' => 'btn btn-large', 'escape' => false));
                    echo $this->Html->link($icon_plus . ' Nuevo Curso', array('controller' => 'cursos', 'action' => 'nuevo'),
                        array('class' => 'btn btn-large', 'escape' => false));
                    echo $this->Form->create('Curso', array('action' => 'search', 'type' => 'get', 'class' => 'form-inline btn btn-large')); 
                    echo $this->Form->input('q', array('label' => false, 'placeholder' => 'Buscar Cursos...')); 
                    echo $this->Form->end(array('label' => 'Buscar', 'class' => 'search-btn', 'div' => false)); 
                ?>
                
            </div>
        <?php } ?>
        <?php if ($this->Session->read('App.settings.contenido_derechos')) {?>
            <div class="btn-group">
                <?php 
                    echo $this->Html->link($icon_list . ' Derechos de Autor', array('controller' => 'derechos', 'action' => 'index'),
                        array('class' => 'btn btn-large', 'escape' => false));
                    echo $this->Html->link($icon_plus . ' Nuevo Derecho', array('controller' => 'derechos', 'action' => 'nuevo'),
                        array('class' => 'btn btn-large', 'escape' => false));
                    echo $this->Form->create('Derecho', array('action' => 'search', 'type' => 'get', 'class' => 'form-inline btn btn-large')); 
                    echo $this->Form->input('q', array('label' => false, 'placeholder' => 'Buscar Derechos de Autor...')); 
                    echo $this->Form->end(array('label' => 'Buscar', 'class' => 'search-btn', 'div' => false)); 
                ?>
                
            </div>
        <?php } ?>
    </div>
</div>