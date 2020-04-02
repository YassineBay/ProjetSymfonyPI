<?php

namespace GroupBundle\Controller;

use GroupBundle\Entity\GroupLiv;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GroupLivController extends Controller
{
    /**
     * @Route("/show")
     */
    public function showAction()
    {
        $group = $this->getDoctrine()->getRepository(GroupLiv::class)->findAll();
        return $this->render('@Group/GroupLiv/show.html.twig',["group"=>$group]);

    }

}
