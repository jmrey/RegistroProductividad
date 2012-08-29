<?php
App::uses('AuthComponent', 'Controller/Component');

/**
 * Modelo de Contenido. 
 */
class Contenido extends AppModel {
    /**
     * Nombre de Modelo
     * @var String 
     */
    public $name = 'Contenido';
    
    /**
     * Nombre de la Tabla en la Base de Datos que utilizará el modelo.
     * @var String 
     */
    public $useTable = 'contenidos';
    
    /**
     * Obtiene el valor de la propiedad con NOMBRE = $name
     * @param type $name
     * @return string 
     */
    public function getValue($name = null) {
        $contenido = $this->findByName($name);
        return ($contenido != null) ? $contenido['Contenido']['content'] : null;
    }
    
    /**
     * Establece un valor a una propiedad en base a su nombre.
     * @param type $name Nombre de la Propiedad
     * @param type $value Nuevo valor de la propiedad.
     * @return boolean 
     */
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
    
    /**
     * Obtiene una porpiedad en base a su nombre y tipo.
     * @param String $property Nombre de la Propiedad
     * @param String $type Tipo de la Propiedad
     * @return type 
     */
    public function getPropertyValue($property = null, $type = 'text') {
        $conditions = array(
            'Contenido.name' => $property,
            'Contenido.type' => $type
        );
        
        if ($type == 'bool') {
            return ($this->field('content', $conditions) === 'true');
        }
        return $this->field('content', $conditions);
    }
    
    /**
     * Obtiene todos las propiedades de la aplicación.
     * @return array 
     */
    public function getProperties() {
        $conditions = array(
            'conditions'=> array('Contenido.type' => 'property'),
            'fields' => array('Contenido.name', 'Contenido.content')
        );
        return $this->find('list', $conditions);
    }
}
?>
