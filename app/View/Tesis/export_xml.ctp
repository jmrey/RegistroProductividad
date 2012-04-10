<?php
    $xmlObject = Xml::fromArray($tesis, array('format' => 'tags')); // You can use Xml::build() too
    echo $xmlObject->asXML();
?>

