<?php

namespace ApiHistogram\ApiHistogramBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $siteManager = $this->get("api_histogram.site_manager");

        $siteManager->setUp();
        $siteManager->getSites();

        return $this->render('ApiHistogramBundle:Default:index.html.twig', array('name' => $name));
    }
}
