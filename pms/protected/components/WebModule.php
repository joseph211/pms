<?php

class WebModule extends CWebModule {
    public $publishDirectory = false;
    public $hashByName = false;
    public $level = -1;

    private $m_assetsUrl;
    public function getAssetsUrl($hashByName = null,$level = null) {
        if(!isset($this->m_assetsUrl)) {
            if(!isset($hashByName)) {
                $hashByName = $this->hashByName;
            }
            if(!isset($level)) {
                $level = $this->level;
            }
            $this->m_assetsUrl = Yii::app()->getAssetManager()->publish(
                Yii::getPathOfAlias("{$this->id}.assets"),$hashByName,$level,true);
        }
        return $this->m_assetsUrl;
    } // function getAssetsUrl($hashByName,$level)

    public function publishScriptFile($relativeUrl,$hashByName = null) {
        if(!isset($hashByName)) {
            $hashByName = $this->hashByName;
        }
        if($this->publishDirectory) {
            $url = $this->getAssetsUrl($hashByName).$relativeUrl;
        }
        else {
            $url = Yii::app()->getAssetManager()->publish(
                Yii::getPathOfAlias("{$this->id}.assets").$relativeUrl
               ,$hashByName
            );
        }
        Yii::app()->clientScript->registerScriptFile($url);
        return $url;
    } // function publishScriptFile($relativeUrl,$hashByName)

    public function publishCssFile($relativeUrl,$hashByName = false) {
        if(!isset($hashByName)) {
            $hashByName = $this->hashByName;
        }
        if($this->publishDirectory) {
            $url = $this->getAssetsUrl($hashByName).$relativeUrl;
        }
        else {
            $url = Yii::app()->getAssetManager()->publish(
                Yii::getPathOfAlias("{$this->id}.assets").$relativeUrl
               ,$hashByName
            );
        }
        Yii::app()->clientScript->registerCssFile($url);
        return $url;
    } // function publishCssFile($relativeUrl,$hashByName)

    public function publishAssetFile($relativeUrl,$hashByName = false) {
        if(!isset($hashByName)) {
            $hashByName = $this->hashByName;
        }
        if($this->publishDirectory) {
            $url = $this->getAssetsUrl($hashByName).$relativeUrl;
        }
        else {
            $url = Yii::app()->getAssetManager()->publish(
                Yii::getPathOfAlias("{$this->id}.assets").$relativeUrl
               ,$hashByName
            );
        }
        return $url;
    } // function publishAssetFile($relativeUrl,$hashByName)
}; // class Module extends CWebModule