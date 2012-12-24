<?php

namespace SocialogSEO;

use Zend\Mvc\MvcEvent;

/**
 * Socialog SEO
 */
class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $sm = $app->getServiceManager();

        $app->getEventManager()->attach(MvcEvent::EVENT_RENDER, function($e) use ($sm) {
            $view = $sm->get('ViewRenderer');
            $config = $sm->get('Config');
            $view->headMeta()->appendName('robots', $config['socialog-seo']['content']);
            $view->headLink(array(
                'rel'   => 'author',
                'href'  => 'humans.txt',
            ));
        }, 999);
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

}
