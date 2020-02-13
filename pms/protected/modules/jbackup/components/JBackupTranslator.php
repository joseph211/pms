<?php
/**
 * JBackupTranslator
 * Class responsible for the translations in the module
 * @author Juan David Rodriguez R. <jdrodriguez429@gmail.com.com> @juanda1015
 * @copyright 2013 - Juan David Rodriguez Ramirez
 * @license New BSD License
 */
class JBackupTranslator
{
    
    public static function t($category, $keyword = null, $params = array()){

        if (empty($keyword)) {
            return $category;
        }

        return Yii::t("JBackupModule.$category", $keyword, $params);
    }
}
