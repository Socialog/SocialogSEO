<?php

namespace SocialogSEO\Sitemap;

use DateTime;

class Item
{
    /**
     * URL Url of the page
     * 
     * @var string
     */
    protected $url;
    
    /**
     * Last Modification Time of the page
     * @var DateTime
     */    
    protected $lastModificationTime;

    /**
     * Change ferequency
     * 
     * @var string
     */
    protected $changeFrequency;

    /**
     * Priority
     * 
     * @var float
     */
    protected $priority = 0.5;
    
    /**
     * @param string $url
     * @param DateTime $lastmod
     * @param string $changefreq
     * @param float $priority
     */
    public function __construct($url, DateTime $lastmod = null, $changefreq = 'never', $priority = 0.5)
    {
        $this->setUrl($url);
        $this->setLastModificationTime($lastmod);
        $this->setChangeFrequency($changefreq);
        $this->setPriority($priority);
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * 
     * @param type $url
     */
    public function setUrl($url)
    {
        $this->url = (string)$url;
    }
    
    /**
     * @return DateTime
     */
    public function getLastModificationTime()
    {
        return $this->lastModificationTime;
    }
    
    /**
     * @param DateTime $lastModificationTime
     */
    public function setLastModificationTime(DateTime $lastModificationTime)
    {
        $this->lastModificationTime = $lastModificationTime;
    }

    public function getChangeFrequency()
    {
        return $this->changeFrequency;
    }
    
    /**
     * Set the change frequency, possible input is
     *
     * - always
     * - hourly
     * - daily
     * - weekly
     * - monthly
     * - yearly
     * - never
     * 
     * @param string $changeFrequency
     */
    public function setChangeFrequency($changeFrequency)
    {
        $this->changeFrequency = (string)$changeFrequency;
    }
    
    /**
     * The priority
     * 
     * @return float
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set the priority
     * 
     * @param float $priority
     */
    public function setPriority($priority)
    {
        $this->priority = (float)$priority;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'loc'           => utf8_encode($this->url),
            'lastmod'       => $this->getLastModificationTime()->format('c'),
            'changefreq'    => $this->getChangeFrequency(),
            'priority'      => $this->getPriority(),
        );
    }
}