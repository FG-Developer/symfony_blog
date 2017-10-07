<?php

namespace AppBundle\Helper;

use AppBundle\Helper\Product;

class UtilityHelper
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Get blog categories
     *
     * @return Category
     */
    public function getPostCategories()
    {
        $container = $this->container;
        return $container->get("doctrine")->getRepository('AppBundle:Category')->findByStatus(1);
    }
}
