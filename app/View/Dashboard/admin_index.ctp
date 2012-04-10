<div class="box dashboard">
    <p class="welcome-message">Hola, 
        <?php 
        $name = implode(' ', explode(' ', $authUser['nombre'], -2));
        echo $this->Html->link($name, array(
            'controller' => 'users',
            'action' => 'perfil'
        ), array('class' => 'capitalize')); ?>, bienvenido.
        <?php 
            if ($isAdmin) {
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-cog'));
                echo $this->Html->link($icon_plus . 'Configuración', array('controller' => 'users', 'action' => 'config', 'admin' => $isAdmin),
                    array('class' => 'right', 'escape' => false));
            }
        ?>
    </p>
    <?php 
        /*if ($isAdmin) {
            $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-cog'));
            echo $this->Html->link($icon_plus, array('controller' => 'users', 'action' => 'config', 'admin' => $isAdmin),
                array('class' => 'btn btn-large right', 'escape' => false));
        }*/
        $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus'));
        $icon_list = $this->Html->tag('i', '', array('class' => 'icon-list'));
        if ($content_articles) {
    ?>
        <div class="btn-group">
            <?php 
                
                echo $this->Html->link($icon_list . ' Artículos', array('controller' => 'articulos', 'action' => 'index'),
                    array('class' => 'btn btn-large', 'escape' => false));
            ?>
            <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <?php 
                        echo $this->Html->link($icon_plus . ' Nuevo', array('controller' => 'articulos', 'action' => 'agregar'),
                            array('escape' => false)); 
                    ?>
                </li>
            </ul>
        </div>
    <?php } ?>
    <?php if ($content_books) {?>
        <div class="btn-group">
            <?php 
                echo $this->Html->link($icon_list . ' Libros', array('controller' => 'libros', 'action' => 'index'),
                    array('class' => 'btn btn-large', 'escape' => false)); 
            ?>
            <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <?php 
                        echo $this->Html->link($icon_plus . ' Nuevo', array('controller' => 'libros', 'action' => 'agregar'),
                            array('escape' => false)); 
                    ?>
                </li>
            </ul>
        </div>
    <?php } ?>
    <?php if ($content_chapters) {?>
        <div class="btn-group">
            <?php 
                echo $this->Html->link($icon_list . ' Capítulos Libros', array('controller' => 'capitulos', 'action' => 'index'),
                    array('class' => 'btn btn-large', 'escape' => false)); 
            ?>
            <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <?php 
                        echo $this->Html->link($icon_plus . ' Nuevo', array('controller' => 'capitulos', 'action' => 'agregar'),
                            array('escape' => false)); 
                    ?>
                </li>
            </ul>
        </div>
    <?php }?>
    <?php if ($content_patents) {?>
        <div class="btn-group">
            <?php 
                echo $this->Html->link($icon_list . ' Patentes', array('controller' => 'patentes', 'action' => 'index'),
                    array('class' => 'btn btn-large', 'escape' => false)); 
            ?>
            <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <?php 
                        echo $this->Html->link($icon_plus . ' Nuevo', array('controller' => 'patentes', 'action' => 'agregar'),
                            array('escape' => false)); 
                    ?>
                </li>
            </ul>
        </div>
    <?php }?>
</div>