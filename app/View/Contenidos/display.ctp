<div class="hero-unit box">
    <?php if ($isAdmin): ?>
    <div class="btn-group right">
        <?php 
            $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-pencil'));
            echo $this->Html->link($icon_plus, array('controller' => 'contenidos', 'action' => 'editar', $contenido['Contenido']['id']),
                array('class' => 'btn btn-small', 'escape' => false));
        ?>
    </div>
    <?php endif; ?>
    <h1><?php echo $contenido['Contenido']['title']; ?></h1>
    <div><?php echo $contenido['Contenido']['content']; ?></div>
</div>