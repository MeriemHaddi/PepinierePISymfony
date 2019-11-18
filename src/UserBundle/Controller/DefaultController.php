<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user=null;
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->redirect("//localhost/pepinierepi/web/app_dev.php/heaven/product/");
        }
        return $this->redirect("//localhost/pepinierepi/web/app_dev.php/heaven/");
    }
}
