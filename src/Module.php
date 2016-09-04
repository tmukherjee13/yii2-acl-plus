<?php
namespace tmukherjee13\aclplus;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'tmukherjee13\aclplus\controllers';
    
    public function init() {
        parent::init();
        //die('asdfds');
        // custom initialization code goes here
        
        // initialize the module with the configuration loaded from config.php
        // \Yii::configure($this, require (__DIR__ . '/config/config.php'));
        // $sFilePathConfig = __DIR__ . '/config/_routes.php';
        // // echo $sFilePathConfig;
        // // die;
        // if (file_exists($sFilePathConfig)) {
        //     \Yii::$app->getUrlManager()->addRules(require ($sFilePathConfig));
        // }
        
    }
    
}
