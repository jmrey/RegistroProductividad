<?php if (isset($titulo)) { ?>
<div class="box">
    <?php if ($isAdmin): ?>
    <div class="btn-group right">
        <?php 
            $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-pencil'));
            echo $this->Html->link('Editar ' . $icon_plus, array('controller' => 'contenidos', 'action' => 'editar', 'titulo', 'admin' => $isAdmin),
                array(/*'class' => 'btn btn-mini',*/ 'escape' => false));
        ?>
    </div>
    <?php endif; ?>
    <h1 class="title"><?php echo $titulo;?></h1>
</div>
<?php } ?>
<div class="hero-unit box">
    <?php if ($isAdmin): ?>
    <div class="btn-group right">
        <?php 
            $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-pencil'));
            echo $this->Html->link('Editar ' . $icon_plus, array('controller' => 'contenidos', 'action' => 'editar', $contenido['name'], 'admin' => $isAdmin),
                array(/*'class' => 'btn btn-mini',*/ 'escape' => false));
        ?>
    </div>
    <?php endif; ?>
    <h1><?php echo $contenido['title']; ?></h1>
    <div><?php echo $contenido['content']; ?></div>
</div>