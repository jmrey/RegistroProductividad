<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta charset="UTF-8" />
        <title>Registro de Productividad</title>
        <meta name="description" content="" />
        <meta name="author" content="" />
        <?php
            echo $this->Html->meta('icon');
            echo $this->Html->css(array('bootstrap', 'main', 'jquery.fileupload-ui'));
            echo $scripts_for_layout;
        ?>
    </head>
    <body>
        <div class="wrapper">
            <?php echo $this->element('header'); ?>
            <div class="container">
                <?php echo $content_for_layout; ?>
            </div>    
        </div>
        <footer class="fixed-bottom">
            <?php echo $this->element('footer'); ?>
        </footer>
    </body>
    <?php 
        //$scripts_array = array();
        $scripts_array = array('jquery-1.7.1');
        if (isset($useJFileUpload)) {
            $extra_scripts = array(
                'blueimp-jfu/js/vendor/jquery.ui.widget',
                'tmpl.min',
                'blueimp-jfu/js/vendor/load-image.min',
                'blueimp-jfu/js/vendor/canvas-to-blob.min',
                'bootstrap.min',
                'blueimp-jfu/js/vendor/bootstrap-image-gallery.min',
                'blueimp-jfu/js/jquery-jfu-all.min',
                'blueimp-jfu/js/locale'
            );
        } else {
            $extra_scripts = array(
                'bootstrap-alert', 'bootstrap-dropdown', 'bootstrap-button','bootstrap-typehead'
            );
        }
        
        $scripts_array = array_merge($scripts_array, $extra_scripts);
        array_push($scripts_array, 'main');
        echo $this->Html->script($scripts_array);
    ?>
</html>
