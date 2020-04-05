<?php

namespace GroupBundle\Controller;

use AppBundle\Entity\Personne;
use AppBundle\Entity\User;
use GroupBundle\Entity\GroupLiv;
use GroupBundle\Entity\Rate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\Tests\Compiler\G;
use Symfony\Component\HttpFoundation\Request;

class GroupLivController extends Controller
{
    /**
     * @Route("/show")
     */
    public function showAction()
    {
        #get all the groups
        $group = $this->getDoctrine()->getRepository(GroupLiv::class)->showGrpLiv();

        #iterate over group array
        for($i = 0; $i<=count($group)-1; $i++){
            #get the rate of each group by id
            $rate = $this->getDoctrine()->getRepository(Rate::class)->getGrpRate($group[$i]->getIdGroup());
            #calculate the average of the rate
            $avg = $this->calcRate($rate);
            #set each rate to its group
            $group[$i]->setRating($avg);
        }

        return $this->render('@Group/GroupLiv/show.html.twig', ["group" => $group]);

    #}

    }

    /**
     * @Route("/add")
     */

    public function addAction(Request $request){



        $group = new GroupLiv();
        $etat = $this->getDoctrine()->getManager()->getRepository(User::class)->find($this->container->get('security.token_storage')->getToken()->getUser());
        $group->setIdAdmin($etat);

        $form= $this->createForm('GroupBundle\Form\GroupLivType', $group);
        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted() ){
            $em =$this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();
        }

        return $this->render("@Group/GroupLiv/add.html.twig", ["form"=>$form->createView()]);

    }

    public function calcRate($rateArr){

        if (!empty($rateArr)) {
            $s = 0;
            $i = 0;

            foreach ($rateArr as $r) {
                $s += $r->getRateValue();
                $i++;
            }

            $avg = $s / $i;
        }else{
            $avg = 0;
        }

        return $avg;

    }

    /**
     * @Route("/grpDet/{id}", name="details")
     */

    public function grpDetailsAction($id){

        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository(GroupLiv::class)->find($id);

        $rate = $em->getRepository(Rate::class)->getGrpRate($id);
        $users = $em->getRepository(User::class)->showMembers($id);

        $avg = $this->calcRate($rate);

        return $this->render("@Group/GroupLiv/grpDetails.html.twig", [
            "group"=>$group,
            "rate"=>$avg,
            "members"=>$users
        ]);

    }

}
