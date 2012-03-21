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
            echo $this->Html->css(array('bootstrap', 'main'));
            echo $scripts_for_layout;
        ?>
    </head>
    <body>
        <div class="navbar navbar-fixed-top navbar-inner">
            <div class="container" id="ipn-header">
                <div class="logo-ipn left">
                    <h1>Instituto Polit&eacute;cnico Nacional</h1>
                    <a class="left" href="http://www.ipn.mx">
                        <?php echo $this->Html->image('logo-IPN.png', array('alt' => 'Instituto Politecnico Nacional','class' => 'left', 'height' => '60px')); ?>
                    </a>
                </div>
                <div class="logo-escom right">
                    <h1>Escuela Superior de C&oacute;mputo</h1>
                    <a class="right" href="http://www.escom.ipn.mx">
                        <?php echo $this->Html->image('escom.png', array('alt' => 'Instituto Politecnico Nacional','class' => 'left', 'height' => '60px')); ?>
                    </a>
                </div>
                <div class="main-menu-container">
                    <?php 
                        echo $this->element('menu', array(
                            'menu' => array(
                                'Inicio' => '/',
                                'Acerca' => '/acerca',
                                'Contacto' => '/contacto'                            
                            ),
                            'class' => ''
                        ));
                    
                        echo $this->element('menu', array(
                            'menu' => array(
                                'Registrarme' => array('url' => '/signup', 'visibleTo' => 'guests'),
                                'Iniciar Sesión' => array('url' => '/login', 'visibleTo' => 'guests'),
                                'Escritorio' => array('url' => '/dashboard', 'visibleTo' => 'auth'),
                                'Cerrar Sesión' => array('url' => '/logout', 'visibleTo' => 'auth')
                            ),
                            'class' => 'right'
                        )); 
                    ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="container">
            <?php echo $content_for_layout; ?>
        </div>
        <footer class="fixed-bottom">
            <?php
                echo $this->element('footer');
            ?>
        </footer>
    </body>
    <?php 
        $scripts_array = array('jquery-1.7.1', 'bootstrap-alert', 'bootstrap-dropdown', 'bootstrap-button','bootstrap-typehead','main');
        echo $this->Html->script($scripts_array); 
    ?>
</html>
