<?php
App::uses('AuthComponent', 'Controller/Component');

class Contenido extends AppModel {
    public $name = 'Contenido';
    public $useTable = 'contenidos';
    
    public function getValue($name = null) {
        $contenido = $this->findByName($name);
        return ($contenido != null) ? $contenido['Contenido']['content'] : null;
    }
    
    public function setProperty($name = null, $value = null) {
        $contenido = $this->findByName($name);
        if (!empty($contenido)) {
            $contenido['Contenido']['content'] = $value;
            if ($this->save($contenido, false, array('content'))) {
                return true;
            }
        }
        return false;
    }
    
    public function getPropertyValue($property = null, $type = 'string') {
        $conditions = array(
            'Contenido.name' => $property,
            'Contenido.type' => 'property'
        );
        
        if ($type == 'bool') {
            return $this->field('content', $conditions) === 'true';
        }
        return $this->field('content', $conditions);
    }
    
    public function getProperties() {
        $conditions = array(
            'Contenido.type' => 'property'
        );
        return $this->find('all', $conditions);
    }
}
?>
