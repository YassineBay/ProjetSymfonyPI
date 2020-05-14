<?php

namespace NotificationBundle\Controller\Api;

use NotificationBundle\Entity\Notifications;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{

/**
     * @Route("/api/notifications")
     * @Method("GET")
     */
    public function showAction()
    {
        $listNotif = $this->getDoctrine()->getManager()->getRepository(Notifications::class)->findAll();

        if(empty($listNotif)){
           $response =  array(
               "code"=>"1",
               "message"=>"post not found",
               "error"=>null,
               "result"=>null
            );

        return new JsonResponse($response,HTTP_NOT_FOUND);
        }
        $data = $this->get("jms_serializer")->serialize($listNotif,'json');
        $response =  array(
            "code"=>"1",
            "message"=>"Success",
            "error"=>null,
            "result"=>json_decode($data)
        );
        return new JsonResponse($response,200);

    }



}