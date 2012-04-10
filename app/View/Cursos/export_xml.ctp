<?php
    $xmlObject = Xml::fromArray($cursos, array('format' => 'tags')); // You can use Xml::build() too
    echo $xmlObject->asXML();
?>

