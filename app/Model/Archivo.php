<?php
App::uses('AuthComponent', 'Controller/Component');

/**
 * Modelo de Archivo. 
 */
class Archivo extends AppModel {
    /**
     * Nombre del Modelo.
     * @var String 
     */
    public $name = 'Archivo';
    
    /**
     * Nombre de la tabla asociada al Modelo
     * @var String 
     */
    public $useTable = 'archivos';
    
    /**
     * Define que comportamientos tendrá el modelo.
     * @var Array 
     */
    var $actsAs = array( 
        'Media.Transfer', 
        'Media.Coupler', 
        'Media.Generator' 
    );
    
    /**
     * Arreglo de validaciones del Archivo.
     * @var Array  
     */
    var $validate = array( 
        'file' => array(
            'mimeType' => array(
                'rule' => array('checkMimeType', false, array( 'image/jpeg', 'image/png', 'text/plain'))
            )
        )
    );
    
    /**
     * Busca todos los archivos en base al tipo de Contenido e Identicador.
     * 
     * @param String $content Tipo de contenido asociado al archivo.
     * @param Integer $id Identificador del Archivo.
     * @return Arhivo 
     */
    public function findAllByContentAndId($content = null, $id = null) {
        $conditions = array('Archivo.content_id =' => $id);
        return $this->findAllByContentType($content, array(), $conditions);
    }
    
    /**
     * Verifica si existe Contenido.
     * 
     * @param String $content Tipo de contenido.
     * @param Integer $id Identificador de Contenido.
     * @return boolean True si existe, False si el contenido no existe.
     */
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
    
    /**
     * Obtiene el contenido.
     * 
     * @param String $type Tipo de contenido del archivo.
     * @param Integer $id Identificador del archivo.
     * @return Archivo 
     */
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
    
    /**
     * Función llamada antes de guardar los datos del Archivo en la Base de Datos.
     * @return boolean 
     */
    public function beforeSave() {
        $this->data[$this->alias]['thumbnail_url'] = '/media/filter/thumbnail/img/' . $this->data[$this->alias]['basename'];
        $this->data[$this->alias]['url'] = '/media/transfer/img/'. $this->data[$this->alias]['basename'];
        //pr($this->data[$this->alias]);
        return true;
    }
}
?>
