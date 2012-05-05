<div class="box">
    <?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<h2><?php echo $name; ?></h2>
<p class="error alert alert-error">
    <strong><?php echo __d('cake', 'Error'); ?>: </strong>
    <?php printf(
            __d('cake', 'La url pedida %s no existe.'),
            "<strong>'{$url}'</strong>"
    ); ?>
    Si está seguro que la url es válida, contacte al administrador. Gracias.
</p>
<p class="alert alert-info">
    Este sistema se encuentra aún en desarrollo, lamentamos el inconveniente, por favor envíanos la url que tratas de acceder. Gracias.
</p>
<form class="form-inline container-fluid big" method="post" action="/feedback/issues">
	<fieldset>
		<legend>Información</legend>
		<div class='input text required'>
                    <label for="ErrorUrl">Url:</label>
                    <input id="ErrorUrl" type="text" value="<?php echo $_SERVER['REQUEST_URI']; ?>" name="data[Error][url]">
		</div>
		<div class='row-fluid'>
                    <label for="ErrorEmail">Tu email:</label>
                    <input id="ErrorEmail" type="text" value="<?php echo AuthComponent::user('email'); ?>" name="data[Error][user_email]">
                    <input type="hidden" value="<?php echo AuthComponent::user('username'); ?>" name="data[Error][user]">
		</div>
	</fieldset>
	<fieldset>
        <legend>Alguna información que quieras agregar:<span id="resumeCounter" class="counterText">(500)</span></legend>
        <div class="row-fluid">
            <div class="span12 no-label">
                <div class="input textarea"><textarea name="data[Error][resumen]" id="resumeTextarea" cols="30" rows="6"></textarea></div>            
            </div>
        </div>
    </fieldset>
    <div class="form-actions f-right">
        <input class="btn btn-success btn-large" type="submit" value="Enviar">
        <a class="btn btn-large" href="javascript: history.go(-1)">Regresar</a>    
    </div>
</form>
<?php
    if (Configure::read('debug') > 0 ):
            echo $this->element('exception_stack_trace');
    endif;
?>
</div>