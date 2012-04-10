<div class="box dashboard">
    <header class="admin">
        <h1 class="title btn-small">Administraci&oacute;n</h1>
        <div class="btn-group right">
            <?php 
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-cog icon-white'));
                echo $this->Html->link($icon_plus . ' Ajustes', array('controller' => 'dashboard', 'action' => 'config', 'admin' => 1),
                    array('class' => 'btn btn-small btn-success', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home icon-white'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('controller' => 'dashboard', 'action' => 'index', 'admin' => 0),
                    array('class' => 'btn btn-small btn-success', 'escape' => false));
                
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

                echo $this->Html->link($icon_list . ' Artículos', array('controller' => 'articulos', 'action' => 'index'),
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
                echo $this->Html->link($icon_list . ' Libros', array('controller' => 'libros', 'action' => 'index'),
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
                echo $this->Html->link($icon_list . ' Capítulos Libros', array('controller' => 'capitulos', 'action' => 'index'),
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
                echo $this->Html->link($icon_list . ' Patentes', array('controller' => 'patentes', 'action' => 'index'),
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
                echo $this->Html->link($icon_list . ' Tesis', array('controller' => 'tesis', 'action' => 'index'),
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
                echo $this->Html->link($icon_list . ' Congresos', array('controller' => 'congresos', 'action' => 'index'),
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
    </div>
</div>
