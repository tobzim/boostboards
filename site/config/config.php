<?php

return [
    'debug' => true,
    'panel' => [
        'install' => true,
    ],
    'languages' => false,
    'thumbs' => [
        'srcsets' => [
            'default' => [400, 800, 1200, 1800, 2400],
            'card'    => [600, 1200, 1800],
        ],
        'quality' => 86,
        'format'  => 'webp',
    ],
    'routes' => [
        [
            'pattern' => 'sitemap.xml',
            'action'  => function () {
                $pages = site()->pages()->index()->filterBy('status', 'listed');
                $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
                $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
                foreach ($pages as $p) {
                    $xml .= "  <url><loc>" . $p->url() . "</loc></url>\n";
                }
                $xml .= '</urlset>';
                return new Kirby\Cms\Response($xml, 'application/xml');
            }
        ],
    ],
];
