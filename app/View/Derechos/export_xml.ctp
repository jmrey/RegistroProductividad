<?php
    $xmlObject = Xml::fromArray($patentes, array('format' => 'tags')); // You can use Xml::build() too
    echo $xmlObject->asXML();
?>

