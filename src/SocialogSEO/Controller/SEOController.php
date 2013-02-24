<?php

namespace SocialogSEO\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


/**
 * Search Engine Optimalization
 */
class SEOController extends AbstractActionController
{
    /**
     * Robots.txt
     *
     * @see http://www.robotstxt.org/robotstxt.html
     */
    public function robotsAction()
    {
        $sm = $this->getServiceLocator();

        $config = $sm->get('Config');
        $config = $config['socialog-seo']['robots'];

        $content = "User-agent: {$config['user-agent']}\n";

        foreach ($config['disallow'] as $rule) {
            $content.= "Disallow: $rule\n";
        }

        $this->getResponse()
            ->getHeaders()
            ->addHeaderLine('Content-Type', 'text/plain');


        return $this
            ->getResponse()
            ->setContent($content) ;
    }

    /**
     * Humans.txt
     *
     * @see http://humanstxt.org/
     */
    public function humansAction()
    {
        $sm = $this->getServiceLocator();

        $config = $sm->get('Config');
        $config = $config['socialog-seo']['robots'];

        $view = new ViewModel;
        $view->setTemplate('humans');
        $view->setTerminal(true);

        $this->getResponse()
            ->getHeaders()
            ->addHeaderLine('Content-Type', 'text/plain');


        return $view;
    }
}
