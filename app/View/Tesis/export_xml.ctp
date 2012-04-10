<?php
    $xmlObject = Xml::fromArray($articulos, array('format' => 'tags')); // You can use Xml::build() too
    echo $xmlObject->asXML();
?>

