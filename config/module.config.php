<?php

return array(
    /**
     * Socialog SEO
     */
    'socialog-seo' => array(
        'robots' => array(
            'user-agent' => '*',
            'disallow' => array(),
        ),
        'content' => 'all'
    ),
    /**
     * Router Configuration
     */
    'router' => array(
        'routes' => array(
            'robots.txt' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/robots.txt',
                    'defaults' => array(
                        'controller' => 'socialog-seo',
                        'action' => 'robots',
                    ),
                ),
            ),
            'humans.txt' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/humans.txt',
                    'defaults' => array(
                        'controller' => 'socialog-seo',
                        'action' => 'humans',
                    ),
                ),
            ),
        ),
    ),
    /**
     * Controller Configuration
     */
    'controllers' => array(
        'invokables' => array(
            'socialog-seo' => 'SocialogSEO\Controller\SEOController',
        ),
    ),
    /**
     * View Configuration
     */
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
