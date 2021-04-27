<?php
return [
    'extends' => 'bootstrap3',
    'helpers' => [
        'factories' => [
            'VuFind\View\Helper\Root\RecordDataFormatter' => 'LAReferencia\View\Helper\Root\RecordDataFormatterFactory',
            'LAReferencia\View\Helper\Root\Piwik' => 'VuFind\View\Helper\Root\PiwikFactory',
        ],
        'aliases' => [
            'piwik' => 'LAReferencia\View\Helper\Root\Piwik',
        ]
    ]
];


            
