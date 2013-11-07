<?php

namespace SocialogSEO;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Socialog SEO Module
 */
class Module implements
    BootstrapListenerInterface,
    AutoloaderProviderInterface,
    ConfigProviderInterface
{

    /**
     * @return ServiceLocatorInterface
     */
    protected $sm;

    public function onBootstrap(EventInterface $e)
    {
        $app = $e->getApplication();
        $this->sm = $app->getServiceManager();

        $app->getEventManager()->attach(MvcEvent::EVENT_ROUTE, array($this, 'onPreRoute'), -100);
        $app->getEventManager()->attach(MvcEvent::EVENT_RENDER, array($this, 'onRender'), -100);
    }

    /**
     * Add extra metadata when rendering a page
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function onRender(MvcEvent $e)
    {
        $view = $this->sm->get('ViewRenderer');
        $config = $this->sm->get('Config');
        $view->headMeta()->appendName('robots', $config['socialog-seo']['content']);
        $view->headLink(array(
            'rel' => 'author',
            'href' => 'humans.txt',
        ));
    }

    /**
     * Listen to routing and redirect any seo links
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function onPreRoute(MvcEvent $e)
    {
        $basePath = $e->getRequest()->getBaseUrl();
        $relativePath = substr($e->getRequest()->getUri()->getPath(), strlen($basePath));

        $config = $this->sm->get('Config');
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
