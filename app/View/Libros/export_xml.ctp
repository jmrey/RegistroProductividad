<?php
    $xmlObject = Xml::fromArray($libros, array('format' => 'tags')); // You can use Xml::build() too
    echo $xmlObject->asXML();
?>

