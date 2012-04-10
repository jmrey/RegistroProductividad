<div class="box form">
    <?php $lib = $libro['Libro']; ?>
    <header>
        <h1 class="title btn-small">Libros</h1>
        <div class="btn-group right">
            <?php 
                echo $this->Html->link('Editar', array('controller' => 'libros', 'action' => 'editar', $lib['id']),
                    array('class' => 'btn btn-small'));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-plus'));
                echo $this->Html->link($icon_plus, array('controller' => 'libros', 'action' => 'agregar'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
                echo $this->Html->link($icon_plus, array('controller' => 'users', 'action' => 'dashboard'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-list'));
                echo $this->Html->link($icon_plus, array('controller' => 'libros', 'action' => 'index'),
                    array('class' => 'btn btn-small', 'escape' => false));
                $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-minus'));
                echo $this->Html->link($icon_plus, array('controller' => 'libros', 'action' => 'agregar'),
                    array('class' => 'btn btn-small', 'escape' => false));
            ?>
        </div>
    </header>
    <article class="document">
        <div>
            <h2>Datos de Libro</h2>
            <div class="row-fluid">
                <div class="span6">
                    <span class="label">Numero de ISBN:</span>
                    <?php echo $lib['isbn']; ?>
                </div>
                <div class="span6">
                    <span class="label">Identificador Libro:</span>
                    <?php 
                        $tipo_libro = array( 
                            '0' => 'Autorizado',
                            '1' => 'Compilación',
                            '2' => 'Editado',
                            '3' => 'Publicado',
                            '4' => 'Traducido'
                        );
                    ?>
                    <?php echo $tipo_libro[$lib['tipo_libro']]; ?>

                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <span class="label">Titulo de Libro:</span>
                    <?php echo $lib['titulo']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <span class="label">Editorial:</span>
                    <?php echo $lib['editorial']; ?>
                </div>
                <div class="span6">
                    <span class="label">Edicion:</span>
                    <?php echo $lib['edicion']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Año de Publicación:</span>
                    <?php echo $lib['anio_publicacion']; ?>
                </div>
                <div class="span4">
                    <span class="label">Volumen:</span>
                    <?php echo $lib['volumen']; ?>
                </div>
                <div class="span4">
                    <span class="label">No. Páginas:</span>
                    <?php echo $lib['num_paginas']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Tiraje:</span>
                    <?php echo $lib['tiraje']; ?>
                </div>
                <div class="span8">
                    <span class="label">Idioma:</span>
                    <?php echo $lib['idioma']; ?>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Palabra Clave 1:</span>
                    <?php echo $lib['palabra_clave1']; ?>
                </div>
                <div class="span4">
                    <span class="label">Palabra Clave 2:</span>
                    <?php echo $lib['palabra_clave2']; ?>
                </div>
                <div class="span4">
                    <span class="label">Palabra Clave 3:</span>
                    <?php echo $lib['palabra_clave3']; ?>
                </div>
            </div>
        </div>
        <div>
            <h2>Datos de Autores</h2>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Total Autores:</span>
                    <?php echo $lib['num_autores']; ?>
                </div>
                <span class="info"><i class="icon-info-sign"></i> Se refire al n&uacute;mero de personas que participaron en la elaboraci&oacute;n del art&iacute;culo en cuesti&oacute;n.</span>
            </div>
            <div class="row-fluid">
                <div class="span4">
                    <span class="label">Posición Autor:</span>
                    <?php echo $lib['pos_autor']; ?>
                </div>
                <span class="info"><i class="icon-info-sign"></i> Se refire a la posici&oacute;n que ocupa el investigador en la lista de autores.</span>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <span class="label">Lista de Autores:</span>
                    <?php echo $lib['lista_autores']; ?>
                </div>
            </div>
        </div>
        <div>
            <h2>Resumen</h2>
            <div class="row-fluid">
                <div class="span12 no-label">
                    <?php echo $lib['resumen']; ?>
                </div>
            </div>
        </div>
    </article>
</div>