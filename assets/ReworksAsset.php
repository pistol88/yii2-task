<?php
namespace pistol88\task\assets;

use yii\web\AssetBundle;

class ReworksAsset extends AssetBundle
{
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    
    public $js = [
        'js/reworks.js',
    ];

    public $css = [
        'css/reworks.css',
    ];
    public function init()
    {
        $this->sourcePath = __DIR__ . '/../web';
        parent::init();
    }
}