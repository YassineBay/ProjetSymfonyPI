<?php

namespace PayementBundle\Controller;

use PayementBundle\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Security;





class DefaultController extends Controller
{

    /**
     * @Route("/registercard" , name="show")
     */
    public function indexAction(Request $request)
    {
        $customer = new Customer();

        //Getting Current user
        $user = $this->getUser();

        \Stripe\Stripe::setApiKey('sk_test_2APKdZmMUOLIX9CiUu3hdB9Z00kd880Rdb');
        $form = $this->get('form.factory')
            ->createNamedBuilder('payment-form')
            ->add('token', HiddenType::class, [
                'constraints' => [new NotBlank()],
            ])
            ->add('submit', SubmitType::class)
            ->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em=$this->getDoctrine()->getManager();
                // Getting Form Data

                $firstName=$request->request->get('first_name');
                $lastName=$request->request->get('last_name');
                $token= $request->request->get("payment-form_token");
                $userEmail = $user->getEmail();
                $customer->setEmail($userEmail);
                $customer->setDatecreation(new \DateTime());
                $customer->setFullname($firstName." ".$lastName);

                $stripe_customer =\Stripe\Customer::create([
                    'description' => 'This Client has been created by Fithnitek Project',
                    'source'=>$token,
                    'email'=>$userEmail,
                    'name'=>$firstName." ".$lastName
                ]);

                $customer->setId($stripe_customer->id);
                $em->persist($customer);
                $em->flush();


            }
        }
        return $this->render('@Payement/Default/payement.html.twig', [
            'form' => $form->createView(),
            'stripe_public_key' => $this->getParameter('stripe_public_key'),
        ]);
    }
}
