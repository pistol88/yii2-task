<?php
namespace pistol88\task\assets;

use yii\web\AssetBundle;

class AjaxWidgets extends AssetBundle
{
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    
    public $js = [
        'js/ajax-widgets.js',
    ];

    public $css = [
        'css/ajax-widgets.css',
    ];
    public function init()
    {
        $this->sourcePath = __DIR__ . '/../web';
        parent::init();
    }
}