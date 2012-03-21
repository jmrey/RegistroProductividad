<?php
    $xmlObject = Xml::fromArray($capitulos, array('format' => 'tags')); // You can use Xml::build() too
    echo $xmlObject->asXML();
?>

