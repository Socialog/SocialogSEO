<?php

namespace SocialogSEO\Sitemap;

/**
 * Sitemap
 */
class Sitemap
{
    /**
     * @var \SocialogSEO\Sitemap\Item[]
     */
    protected $items = array();

    /**
     * @param \SocialogSEO\Sitemap\Item $item
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }

    /**
     * @return \SocialogSEO\Sitemap\Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function getViewModel()
    {
        $viewModel = new \Zend\View\Model\ViewModel();
        $viewModel->setVariable('items', $this->getItems());
        $viewModel->setTemplate('socialog-seo/sitemap');

        return $viewModel;
    }
}