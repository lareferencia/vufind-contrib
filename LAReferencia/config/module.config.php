<?php
namespace VuFind\Module\Config;

$config = [
  'vufind' => [
    'plugin_managers' => [
      'recorddriver' => [
        'factories' => [
          'LAReferencia\\RecordDriver\\SolrDefault' => 'LAReferencia\\RecordDriver\\SolrDefaultFactory',
        ],
        'aliases' => [
          'VuFind\\RecordDriver\\SolrDefault' => 'LAReferencia\\RecordDriver\\SolrLAReferencia',
        ],
      ],
    ],
  ],
];

return $config;
