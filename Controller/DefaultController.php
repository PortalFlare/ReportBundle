<?php

namespace PortalFlare\ReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller {
  /**
   * @Route("/report")
   * @Template()
   */
  public function indexAction() {
  }
}
