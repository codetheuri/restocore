<?php

namespace ui\bundles;

use yii\web\AssetBundle;


class MainAsset extends AssetBundle
{
    public $basePath = '@ui/assets';
    public $baseUrl = '@web/providers/interface/assets';
    public $css = [
        [
            'href' => 'oneui/favicon.png',
            'rel' => 'icon',
            'sizes' => '64x64',
        ],
       'assets/img/favicon.ico',
        'assets/css/style.css',
        'assets/lib/animate/animate.min.css',
        'assets/lib/flaticon/font/flaticon.css',
        'assets/lib/owlcarousel/assets/owl.carousel.min.css',
        'assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css',
        'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css',
        'https://fonts.googleapis.com/css?family=Open+Sans:300,400|Nunito:600,700',
    ];
    public $js = [
          'https://code.jquery.com/jquery-3.4.1.min.js',
        'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js',
        'assets/lib/easing/easing.min.js',
      
        'assets/lib/owlcarousel/owl.carousel.min.js',
        'assets/lib/tempusdominus/js/moment.min.js',
        'assets/lib/tempusdominus/js/moment-timezone.min.js',
        'assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js',
        'assets/js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}