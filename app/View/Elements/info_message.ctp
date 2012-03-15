<span class="info">
    <i class="icon-info-sign"></i>
    <?php echo $message; ?>
    <?php
        if ($isAdmin) {
            $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-pencil'));
            echo $this->Html->link($icon_plus, array('controller' => 'users', 'action' => 'configuracion', 'admin' => $isAdmin),
                array('class' => 'btn btn-mini', 'escape' => false, 'alt' => 'Configuración'));
        }
    ?>
</span>