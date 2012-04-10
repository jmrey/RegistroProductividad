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
    
    public function getProperties() {
        $conditions = array(
            'conditions'=> array('Contenido.type' => 'property'),
            'fields' => array('Contenido.name', 'Contenido.content')
        );
        return $this->find('list', $conditions);
    }
    
    /*public function getSettings() {
        $content_articles = $this->getPropertyValue('content_articles', 'bool');
        $content_books = $this->getPropertyValue('content_books', 'bool');
        $content_chapters = $this->getPropertyValue('content_chapters', 'bool');
        $content_patents = $this->getPropertyValue('content_patents', 'bool');
        $validate_accounts = $this->getPropertyValue('validate_accounts', 'bool');
        $force_downloads = $this->getPropertyValue('force_downloads', 'bool');
        
        return compact('content_articles', 'content_books', 'content_chapters',
                'content_patents', 'validate_accounts', 'force_downloads');
    }*/
}
?>
