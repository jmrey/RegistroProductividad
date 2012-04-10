<h1>SEPI</h1>
<p>Hemos recibido una solicitud para cambiar tu contraseña, de no ser así, por favor ignora este mensaje.</p>
<p>Enviado: <?php echo date("Y-m-d H:i:s"); ?></p>

<p>Por favor haga clic en el siguiente enlace para continuar con el procedimiento:
    <?php
        $newPasswordLink = $linkDomain . $this->Html->url(array('controller'=> 'users', 'action' => 'ticket', $keycode));
        echo $this->Html->link($newPasswordLink, $newPasswordLink);
    ?>
</p>