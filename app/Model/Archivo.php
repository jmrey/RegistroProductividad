<?php
App::uses('AuthComponent', 'Controller/Component');

class Archivo extends AppModel {
    public $name = 'Archivo';
    public $useTable = 'archivos';
    
    var $actsAs = array( 
        'Media.Transfer', 
        'Media.Coupler', 
        'Media.Generator' 
    );
    
    var $validate = array( 
        'file' => array(
            'mimeType' => array(
                'rule' => array('checkMimeType', false, array( 'image/jpeg', 'image/png', 'text/plain'))
            )
        )
    );
    
    public function findAllByContentAndId($content = null, $id = null) {
        $conditions = array('Archivo.content_id =' => $id);
        return $this->findAllByContentType($content, array(), $conditions);
    }
    
    public function existsContent($content, $id) {
        $exists = false;
        try {
            $modelClass = Inflector::classify($content);
            $modelClass = ClassRegistry::init($modelClass)->read(null, $id);
            if($modelClass) {
                $exists = true;
            }
        } catch (Exception $e) {
            $exists = false;
        }
        return $exists;
    }
    
    public function getContent($type = null, $id = null) {
        $content = null;
        try {
            $modelClass = Inflector::classify($type);
            $content = ClassRegistry::init($modelClass)->read(null, $id);
        } catch (Exception $e) {
            pr($e);
        }
        return $content;
    }
    
    public function beforeSave() {
        $this->data[$this->alias]['thumbnail_url'] = '/media/filter/thumbnail/img/' . $this->data[$this->alias]['basename'];
        $this->data[$this->alias]['url'] = '/media/transfer/img/'. $this->data[$this->alias]['basename'];
        //pr($this->data[$this->alias]);
        return true;
    }
}
?>
