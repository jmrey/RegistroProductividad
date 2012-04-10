<h1>SEPI</h1>
<p>Este correo es enviado automáticamente para verificar su cuenta de correo: <?php echo $email; ?></p>

<p>Por favor haga clic en el siguiente enlace para verificar su cuenta de correo:
    <?php
        $emailLink = $linkDomain . $this->Html->url(array('controller'=> 'users', 'action' => 'validar', $keycode));
        echo $this->Html->link($emailLink, $emailLink);
    ?>
</p>