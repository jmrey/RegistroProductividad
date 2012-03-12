<div class="box dashboard">
    <div class="btn-group">
        <?php 
            $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus'));
            $icon_list = $this->Html->tag('i', '', array('class' => 'icon-list'));
            echo $this->Html->link($icon_plus . ' Artículos', array('controller' => 'articulos', 'action' => 'agregar'),
                array('class' => 'btn btn-large', 'escape' => false));
        ?>
        <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#">
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li>
                <?php 
                    echo $this->Html->link($icon_list . ' Resumen', array('controller' => 'articulos', 'action' => 'index'),
                        array('escape' => false)); 
                ?>
            </li>
        </ul>
    </div>
    <div class="btn-group">
        <?php 
            echo $this->Html->link($icon_plus . ' Libros', array('controller' => 'libros', 'action' => 'agregar'),
                array('class' => 'btn btn-large', 'escape' => false)); 
        ?>
        <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#">
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li>
                <?php 
                    echo $this->Html->link($icon_list . ' Resumen', array('controller' => 'libros', 'action' => 'index'),
                        array('escape' => false)); 
                ?>
            </li>
        </ul>
    </div>
    <div class="btn-group">
        <?php 
            echo $this->Html->link($icon_plus . ' Capítulos Libros', array('controller' => 'capitulos', 'action' => 'agregar'),
                array('class' => 'btn btn-large', 'escape' => false)); 
        ?>
        <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#">
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li>
                <?php 
                    echo $this->Html->link($icon_list . ' Resumen', array('controller' => 'capitulos', 'action' => 'index'),
                        array('escape' => false)); 
                ?>
            </li>
        </ul>
    </div>
</div>