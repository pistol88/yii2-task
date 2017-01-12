<?php
namespace pistol88\task\assets;

use yii\web\AssetBundle;

class TaskAsset extends AssetBundle
{
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    
    public $js = [
        'js/dvizh.js',
    ];

    public $css = [
        'css/style.css',
    ];
    public function init()
    {
        $this->sourcePath = __DIR__ . '/../web';
        parent::init();
    }
}