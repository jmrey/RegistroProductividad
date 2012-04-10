<?php
    $xmlObject = Xml::fromArray($congresos, array('format' => 'tags')); // You can use Xml::build() too
    echo $xmlObject->asXML();
?>

