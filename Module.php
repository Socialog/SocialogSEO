<?php

namespace SocialogSEO;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

/**
 * Socialog SEO Module
 */
class Module implements
    BootstrapListenerInterface,
    AutoloaderProviderInterface,
    ConfigProviderInterface
{

    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $sm = $app->getServiceManager();

        $app->getEventManager()->attach(MvcEvent::EVENT_ROUTE, function($e) use ($sm) {
                $basePath = $e->getRequest()->getBaseUrl();
                $relativePath = substr($e->getRequest()->getUri()->getPath(), strlen($basePath));

                $config = $sm->get('Config');
                $config = $config['socialog-seo']['redirect'];

                if (isset($config[$relativePath])) {
                    $redirect = $config[$relativePath];
                    $code = 301;
                    $url = null;

                    if (is_string($redirect)) {
                        $url = $redirect;
                    } elseif (is_array($redirect)) {
                        if (isset($redirect['code'])) {
                            $code = $redirect['code'];
                        }
                        if (isset($redirect['url'])) {
                            $url = $redirect['url'];
                        }
                    }

                    $response = $e->getResponse();
                    $response->getHeaders()->addHeaderLine('Location', $url);
                    $response->setStatusCode($code);
                    return $response;
                }
            }, 9999);

        $app->getEventManager()->attach(MvcEvent::EVENT_RENDER, function($e) use ($sm) {
                $view = $sm->get('ViewRenderer');
                $config = $sm->get('Config');
                $view->headMeta()->appendName('robots', $config['socialog-seo']['content']);
                $view->headLink(array(
                    'rel' => 'author',
                    'href' => 'humans.txt',
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
