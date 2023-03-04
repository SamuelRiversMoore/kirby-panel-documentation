<?php

@include_once __DIR__ . '/vendor/autoload.php';

load([
  'Samrm\Documentation' => __DIR__ . '/classes/Documentation.php'
]);

use Samrm\Documentation;
use Kirby\Panel\Panel;

Kirby::plugin('samrm/documentation', [
  'options' => [
    'root' => 'documentation',
    'title' => 'Documentation'
  ],
  'areas' => [
    'documentation' => function ($kirby) {
      return [
        'label' => option('samrm.documentation.title'),
        'icon' => 'document',
        'menu' => true,
        'link' => option('samrm.documentation.root'),
        'views' => [
          [
            'pattern' => option('samrm.documentation.root'),
            'action' => function () {
              $pages = Documentation::getPages();
              if ($pages->count()) {
                Panel::go($pages->first()['url']);
              }
              return [
                'component' => 'documentation',
                'title' => option('samrm.documentation.title'),
                'props' => [
                  'title' => option('samrm.documentation.title'),
                  'pages' => [],
                ]
              ];
            }
          ],
          [
            'pattern' => option('samrm.documentation.root').'/(:any)',
            'action' => function ($id) {
              $pages = Documentation::getPages();
              $page = Documentation::getPage($id);
              if (!$page) {
                if ($pages->count()) {
                  Panel::go($pages->first()['url']);
                } else {
                  Panel::go(option('samrm.documentation.root'));
                }
              }
              return [
                'component' => 'documentation',
                'breadcrumb' => [
                    [
                        'label' => $page['title'],
                        'link'  => option('samrm.documentation.root') . '/' . $id
                    ]
                ],
                'props' => [
                  'title' => option('samrm.documentation.title'),
                  'pages' => $pages->values(),
                  'page' => $page
                ]
              ];
            }
          ]
        ]
      ];
    }
  ]
]);
