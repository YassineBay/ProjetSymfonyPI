<?php

namespace PayementBundle\Controller\Api;

use AppBundle\Entity\User;
use PayementBundle\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;



class DefaultController extends Controller
{

    /**
     * @Route("/api/Mycard")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $customer = new Customer();
        //Getting Current user
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        \Stripe\Stripe::setApiKey('sk_test_2APKdZmMUOLIX9CiUu3hdB9Z00kd880Rdb');
        $form = $this->get('form.factory')
            ->createNamedBuilder('payment-form')
            ->add('token', HiddenType::class, [
                'constraints' => [new NotBlank()],
            ])
            ->add('submit', SubmitType::class)
            ->getForm();
        $userRepo = $em->getRepository('PayementBundle:Customer');
        $cust = $em->getRepository(User::class)->findOneBy(array("id" => $request->get("id")));
        $customer_test = $em->getRepository(Customer::class)->findOneBy(array("iduser" => $request->get("id")));

        if (!empty($customer_test)) {
            //We are going to render to an existing credit card page
            $RetrievedCustomer = \Stripe\Customer::retrieve(array("id"=>$customer_test->getId()));
            return $this->render('@Payement/Default/myCards.html.twig', ["test" => $RetrievedCustomer,
                'form' => $form->createView(),
                'stripe_public_key' => $this->getParameter('stripe_public_key')
            ]);
        } else {
            //var_dump($cust[0]->getId());
            //Check if email exist then show an other View <<<<
            // Getting Form Data
            $customer = new Customer();
            $firstName = $_GET['first_name'];
            $lastName = $_GET['last_name'];
            $token = $request->request->get("payment-form_token");
            $customer->setEmail($cust->getEmail());
            $customer->setIduser($cust);
            //$customer->setIduser($this->container->get('security.token_storage')->getToken()->getUser());
            $customer->setDatecreation(new \DateTime());
            $customer->setFullname($firstName . " " . $lastName);
            $stripe_customer = \Stripe\Customer::create([
                'description' => 'This Client has been created by Fithnitek Project',
                'source' => 'tok_visa',
                'email' => $cust->getEmail(),
                'name' => $firstName . " " . $lastName
            ]);
            $customer->setId($stripe_customer->id);
            $em->persist($customer);
            $em->flush();
            // }
            //$serializer = new Serializer([new ObjectNormalizer()]);
            //$formatted = $serializer->normalize($stripe_customer);
            return new JsonResponse($stripe_customer);
        }
    }

}
