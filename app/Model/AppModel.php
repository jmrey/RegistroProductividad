<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Modelo Base
 *
 * Todos los métodos de este clase serán heredados a todos los Modelos.
 *
 * @package       Cake.Model
 */
class AppModel extends Model {
    
    /**
     * Verifica si un Año está en el rango permitido (1949 - Año Actual)
     * @param Array $check Añó a verificar.
     * @return Boolen Si el añó está en el rango permitido retorna True. 
     */
    public function isYearInRange($check) {
        $value = array_values($check);
        $value = $value[0];
        $initYear = 1949;
        $currentYear = date('Y');
        return ($initYear <= $value && $value <= $currentYear);
    }
    
    /**
     *
     * @param Integer $modelId Identificador del Modelo
     * @param Intefer $userId Identificador del Usuario.
     * @return Boolen Retorna True si el Modelos es encontrado, en otro caso False 
     */
    public function isOwnedBy($modelId, $userId) {
        return $this->field('id', array('id' => $modelId, 'user_id' => $userId)) === $modelId;
    }
}
