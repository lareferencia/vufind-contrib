<?php
namespace LaReferencia\Module\Configuration;

$config = [


  'controllers' => [
      'factories' => [
          /*'api' => 'LaReferencia\VuFindApi\Controller\Factory::getApiController',
          'searchapi' => 'LaReferencia\VuFindApi\Controller\Factory::getSearchApiController',
          'institutions' => 'LaReferencia\Controller\Factory::getInstitutionsController',*/

      ]
  ],
  'router' => [
      'routes' => [
          /*'institutions' => [
            'type'    => 'Zend\Mvc\Router\Http\Segment',
            'options' => [
                'route'    => '/Institutions',
                'defaults' => [
                    'controller' => 'Institutions',
                    'action'     => 'Home',
                ]
            ],
          ],
          'apiHome' => [
              'type' => 'Zend\Mvc\Router\Http\Segment',
              'verb' => 'get,post,options',
              'options' => [
                  'route'    => '/api[/v1][/]',
                  'defaults' => [
                      'controller' => 'Api',
                      'action'     => 'Index',
                  ]
              ],
          ],
          'searchApiv1' => [
              'type' => 'Zend\Mvc\Router\Http\Literal',
              'verb' => 'get,post,options',
              'options' => [
                  'route'    => '/api/v1/search',
                  'defaults' => [
                      'controller' => 'SearchApi',
                      'action'     => 'search',
                  ]
              ]
          ],
          'recordApiv1' => [
              'type' => 'Zend\Mvc\Router\Http\Literal',
              'verb' => 'get,post,options',
              'options' => [
                  'route'    => '/api/v1/record',
                  'defaults' => [
                      'controller' => 'SearchApi',
                      'action'     => 'record',
                  ]
              ]
          ]*/
      ],
  ],
  // This section contains all VuFind-specific settings (i.e. configurations
  // unrelated to specific Zend Framework 2 components).
  'vufind' => [

      // This section contains service manager configurations for all VuFind
      // pluggable components:
      'plugin_managers' => [

          'recorddriver' => [
              'abstract_factories' => ['VuFind\RecordDriver\PluginFactory'],
              'factories' => [
                  'solrdefault' => 'LaReferencia\RecordDriver\Factory::getSolrDefault',
		  'solrmarc' => 'LaReferencia\RecordDriver\Factory::getSolrMarc',
              ],

          ],
      ],

      'recorddriver_tabs' => [

          'LaReferencia\RecordDriver\SolrDefault' => [
              'tabs' => [
                  //'Holdings' => 'HoldingsILS',
                  'Description' => 'Description',
                  //'TOC' => 'TOC',
                  //'UserComments' => 'UserComments',
                  //'Reviews' => 'Reviews',
                  //'Excerpt' => 'Excerpt',
                  //'Preview' => 'preview',
                  //'HierarchyTree' => 'HierarchyTree',
                  //'Map' => 'Map',
                  //'Similar' => 'SimilarItemsCarousel',
		  //Details' => 'StaffViewArray',
              ],
              'defaultTab' => null,
              // 'backgroundLoadedTabs' => ['UserComments', 'Details']
          ],
      ],
  ],
];

return $config;
