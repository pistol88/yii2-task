<?php
namespace pistol88\task\assets;

use yii\web\AssetBundle;

class MembersAsset extends AssetBundle
{
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    
    public $js = [
        'js/members.js',
    ];

    public $css = [
        'css/members.css',
    ];
    
    public function init()
    {
        $this->sourcePath = __DIR__ . '/../web';
        parent::init();
    }
}