<div class="box content">
    <header>
        <h1 class="title btn-small">Capítulos</h1>
        <div class="btn-group right">
            <a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#exportar">
                Guardar como
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <?php 
                    echo $this->Html->link('Texto', array(
                        'controller' => 'capitulos',
                        'action' => 'exportar',
                        'txt'
                        ), array());
                    ?>
                </li>
                <li>
                    <?php 
                    echo $this->Html->link('PDF', array(
                        'controller' => 'capitulos',
                        'action' => 'exportar',
                        'pdf'
                        ), array());
                    ?>
                </li>
                <li>
                    <?php 
                    echo $this->Html->link('XML', array(
                        'controller' => 'capitulos',
                        'action' => 'exportar',
                        'xml'
                        ), array());
                    ?>
                </li>
            </ul>
            <?php
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus'));
                echo $this->Html->link($icon_plus . ' Nuevo Capítulo', array('controller' => 'capitulos', 'action' => 'nuevo'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus . ' Escritorio', array('controller' => 'dashboard', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div> 
    </header>
    <?php echo $this->Session->flash(); ?>
    <table class="table table-condensed table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Detalles</th>
                <th>Título del Capítulo
                    <?php 
                        $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-retweet'));
                        echo $this->Paginator->sort('titulo_capitulo', $icon_plus, array('escape' => false));
                    ?>
                </th>
                <th>Título del Libro
                    <?php echo $this->Paginator->sort('titulo_libro', $icon_plus, array('escape' => false)); ?>
                </th>
                <th>Año
                    <?php echo $this->Paginator->sort('anio_publicacion', $icon_plus, array('escape' => false)); ?>
                </th>
                <th>Editorial
                    <?php echo $this->Paginator->sort('editorial', $icon_plus, array('escape' => false)); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($capitulos as $c):
                    $cap = $c['Capitulo'];
            ?>
            <tr>
                <td><?php echo $cap['id']; ?></td>
                <td>
                    <?php
                        echo $this->Html->link('Ver', $cap['id'],
                                array());
                    ?>
                </td>
                <td><?php echo $cap['titulo_capitulo']; ?></td>
                <td><?php echo $cap['titulo_libro']; ?></td>
                <td><?php echo $cap['anio_publicacion']; ?></td>
                <td><?php echo $cap['editorial']; ?></td>
            </tr>
            <?php
                endforeach;
            ?>
        </tbody>
    </table>
    <?php 
        if (isset($this->Paginator)) {
            echo $this->Paginator->numbers(); 
        }
    ?>
</div>