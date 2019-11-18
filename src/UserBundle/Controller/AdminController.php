<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function AdminAction()
    {

        return $this->render('@User/Admin/admin.html.twig');
    }
}
