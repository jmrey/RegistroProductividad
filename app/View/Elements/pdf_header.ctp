<?php $imgWidth = 40; ?>
<table border=0 style="width:100%">
    <tbody>
        <tr>
            <td rowspan=2 style="width:<?php echo $imgWidth - 10; ?>px;">
                <img src="img/logo-IPN.gif" style="height:<?php echo $imgWidth; ?>px;">
            </td>
            <td>
                <h1>Instituto Polit&eacute;nico Nacional</h1>
            </td>
            <td class="right">
                <h1>Escuela Superior de C&oacute;mputo</h1>
            </td>
            <td class="right" rowspan=2 style="width:<?php echo $imgWidth; ?>px;">
                <img src="img/escom.gif" style="height:<?php echo $imgWidth; ?>px;">
            </td>
        </tr>
        <tr>
            <td class="center" colspan=2>
                <span class="title">Registro de Productividad</span>
            </td>
        </tr>
    </tbody>
</table>
<h1><?php echo $title; ?></h1>
<div>
    <p>Profesor: <span><?php echo strtoupper($authUser['nombre']); ?></span></p>
    <p>No. de Emplado: <span><?php echo $authUser['no_empleado']; ?></span></p>
</div>