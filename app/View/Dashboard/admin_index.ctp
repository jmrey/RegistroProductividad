<div class="box dashboard">
    <header class="admin">
        <h1 class="title btn-small">Administraci&oacute;n</h1>
        <div class="btn-group right">
            <?php 
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-user icon-white'));
                echo $this->Html->link($icon_plus . ' Usuarios', array('admin' => 1, 'controller' => 'users', 'action' => 'index'),
                    array('class' => 'btn btn-small btn-success', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-cog icon-white'));
                echo $this->Html->link($icon_plus . ' Ajustes', array('admin' => 1, 'controller' => 'dashboard', 'action' => 'config'),
                    array('class' => 'btn btn-small btn-success', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('admin' => 0, 'controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
                
            ?>
        </div>
    </header>
    <div class="pane">
        <?php 
            $icon_signal = $this->Html->tag('i', '', array('class' => 'icon-list-alt'));
            $icon_list = $this->Html->tag('i', '', array('class' => 'icon-list'));
        ?>
        <div class="btn-group">
            <?php 

                echo $this->Html->link($icon_list . ' Artículos', array('admin' => 1, 'controller' => 'articulos', 'action' => 'index'),
                    array('class' => 'btn btn-large', 'escape' => false));
            ?>
            <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <?php 
                        echo $this->Html->link($icon_signal . ' Estadísticas', array('controller' => 'articulos', 'action' => 'agregar'),
                            array('escape' => false)); 
                    ?>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <?php 
                echo $this->Html->link($icon_list . ' Libros', array('admin' => 1, 'controller' => 'libros', 'action' => 'index'),
                    array('class' => 'btn btn-large', 'escape' => false)); 
            ?>
            <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <?php 
                        echo $this->Html->link($icon_signal . ' Estadísticas', array('controller' => 'libros', 'action' => 'agregar'),
                            array('escape' => false)); 
                    ?>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <?php 
                echo $this->Html->link($icon_list . ' Capítulos Libros', array('admin' => 1, 'controller' => 'capitulos', 'action' => 'index'),
                    array('class' => 'btn btn-large', 'escape' => false)); 
            ?>
            <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <?php 
                        echo $this->Html->link($icon_signal . ' Estadísticas', array('controller' => 'capitulos', 'action' => 'agregar'),
                            array('escape' => false)); 
                    ?>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <?php 
                echo $this->Html->link($icon_list . ' Patentes', array('admin' => 1, 'controller' => 'patentes', 'action' => 'index'),
                    array('class' => 'btn btn-large', 'escape' => false)); 
            ?>
            <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <?php 
                        echo $this->Html->link($icon_signal . ' Estadísticas', array('controller' => 'patentes', 'action' => 'agregar'),
                            array('escape' => false)); 
                    ?>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <?php 
                echo $this->Html->link($icon_list . ' Tesis', array('admin' => 1, 'controller' => 'tesis', 'action' => 'index'),
                    array('class' => 'btn btn-large', 'escape' => false)); 
            ?>
            <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <?php 
                        echo $this->Html->link($icon_signal . ' Estadísticas', array('controller' => 'tesis', 'action' => 'agregar'),
                            array('escape' => false)); 
                    ?>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <?php 
                echo $this->Html->link($icon_list . ' Congresos', array('admin' => 1, 'controller' => 'congresos', 'action' => 'index'),
                    array('class' => 'btn btn-large', 'escape' => false)); 
            ?>
            <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <?php 
                        echo $this->Html->link($icon_signal . ' Estadísticas', array('controller' => 'congresos', 'action' => 'agregar'),
                            array('escape' => false)); 
                    ?>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <?php 
                echo $this->Html->link($icon_list . ' Cursos', array('admin' => 1, 'controller' => 'cursos', 'action' => 'index'),
                    array('class' => 'btn btn-large', 'escape' => false)); 
            ?>
            <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <?php 
                        echo $this->Html->link($icon_signal . ' Estadísticas', array('controller' => 'cursos', 'action' => 'agregar'),
                            array('escape' => false)); 
                    ?>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <?php 
                echo $this->Html->link($icon_list . ' Derechos de Autor', array('admin' => 1, 'controller' => 'derechos', 'action' => 'index'),
                    array('class' => 'btn btn-large', 'escape' => false)); 
            ?>
            <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <?php 
                        echo $this->Html->link($icon_signal . ' Estadísticas', array('controller' => 'derechos', 'action' => 'agregar'),
                            array('escape' => false)); 
                    ?>
                </li>
            </ul>
        </div>
    </div>
</div>
