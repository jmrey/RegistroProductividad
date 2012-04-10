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
                        'Registrarme' => array('url' => '/registrar', 'visibleTo' => 'guests'),
                        'Iniciar Sesión' => array('url' => '/iniciar_sesion', 'visibleTo' => 'guests'),
                        'Escritorio' => array('url' => array('controller' => 'dashboard', 'action' => 'index'),
                            'matches' => array('/dashboard'), 'visibleTo' => 'auth'),
                        'Cerrar Sesión' => array('url' => '/logout', 'visibleTo' => 'auth')
                    ),
                    'class' => 'right'
                )); 
            ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>