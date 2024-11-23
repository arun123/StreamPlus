<?php

namespace App\Controller;

use App\DataTransferObject\UserAddressDto;
use App\DataTransferObject\UserBasicDto;
use App\DataTransferObject\UserPaymentDto;
use App\Entity\User;
use App\Form\UserAddressType;
use App\Form\UserBasicType;
use App\Form\UserPaymentType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class UserController extends AbstractController
{
    private const USER_CREATE_STEP_ONE = '1';
    private const USER_CREATE_STEP_TWO = '2';
    private const USER_CREATE_STEP_THREE = '3';

    protected $requestStack;
    protected $em;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->requestStack = $requestStack;
        $this->em = $entityManager;

    }



    /**
     * @Route("/", name="landing_page", methods={"GET", "POST"})
     * @Route("/{step}", name="app_user_new", methods={"GET", "POST"})
     */
    public function new(string $step = "1", Request $request,  UserRepository $userRepository): Response
    {
       switch($step) {
            case self::USER_CREATE_STEP_ONE : $form =$this->renderUserCreateFromStepOne();
            break;
            case self::USER_CREATE_STEP_TWO : $form =$this->renderUserCreateFromStepTwo();
            break;
            case self::USER_CREATE_STEP_THREE : $form =$this->renderUserCreateFromStepThree();
            break;
            default : $this->redirectToRoute('app_user_new', ['step' => self::USER_CREATE_STEP_ONE]);
        };

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            switch($step) {
                case self::USER_CREATE_STEP_ONE : 
                    return  $this->handleUserFormStepOne($form);
                    //$this->handleUserFormStepOne($form);
                break;
                case self::USER_CREATE_STEP_TWO : 
                    return $this->handleUserFormStepTwo($form);
                case self::USER_CREATE_STEP_THREE : 
                    return $this->handleUserFormStepThree($form);
                default : $this->redirectToRoute('app_user_new', ['step' => self::USER_CREATE_STEP_ONE]);
            };
        }
        return $this->render(sprintf('user/step%s.html.twig', $step), [
            'form' => $form->createView(),
            'data' => $form->getData()
        ]);

    }

    private function renderUserCreateFromStepOne()
    {
        $userBasicDto = $this->requestStack->getSession()->get('user-form-step-one');

        if (!$userBasicDto instanceof UserBasicDto) {
            $userBasicDto = new UserBasicDto();
        }

        return $this->createForm(UserBasicType::class, $userBasicDto);
    }


    private function renderUserCreateFromStepTwo()
    {
        $userAddressDto = $this->requestStack->getSession()->get('user-form-step-two');

        if (!$userAddressDto instanceof UserAddressDto) {
            $userAddressDto = new UserAddressDto();
        }

        return $this->createForm(UserAddressType::class, $userAddressDto);
    }


    private function renderUserCreateFromStepThree()
    {
        $userPaymentDto = $this->requestStack->getSession()->get('user-form-step-three');

        if (!$userPaymentDto instanceof UserPaymentDto) {
            $userPaymentDto = new UserPaymentDto();
        }

        return $this->createForm(UserPaymentType::class, $userPaymentDto);
    }

    private function handleUserFormStepOne( $form)
    {
        $this->requestStack->getSession()->set('user-form-step-one', $form->getData());
        $data = $form->getData();
        if($data->getSubscriptionType() == User::USER_SUBSCRIPTION_BASIC)
        {
            return $this->redirectToRoute('app_user_new', ['step' => self::USER_CREATE_STEP_TWO]);
        }
        if($data->getSubscriptionType() == User::USER_SUBSCRIPTION_PREMIUM)
        {
            return $this->redirectToRoute('app_user_new', ['step' => self::USER_CREATE_STEP_THREE]);
        }
    }

    private function handleUserFormStepTwo( $form): Response
    {
        $this->requestStack->getSession()->set('user-form-step-two', $form->getData());

        $this->processData();
        return $this->redirectToRoute('app_user_new', ['step' => self::USER_CREATE_STEP_ONE]);
    }

    private function handleUserFormStepThree( $form)
    {
        $this->requestStack->getSession()->set('user-form-step-three', $form->getData());

        $this->processData();
        return $this->redirectToRoute('app_user_new', ['step' => self::USER_CREATE_STEP_ONE]);

    }

    private function processData()
    {
        $userBasicDto = $this->requestStack->getSession()->get('user-form-step-one');
        $userAddrDto = $this->requestStack->getSession()->get('user-form-step-two');
        $userPayDto = $this->requestStack->getSession()->get('user-form-step-three');

        $user = new User();
        $user->setName($userBasicDto->getName());
        $user->setEmail($userBasicDto->getEmail());
        $user->setPhoneNumber($userBasicDto->getPhoneNumber());
        $user->setSubscriptionType($userBasicDto->getSubscriptionType());
        if($userAddrDto)
        {
            $user->setAddress1($userAddrDto->getAddress1());
            $user->setAddress2($userAddrDto->getAddress2());
            $user->setCity($userAddrDto->getCity());
            $user->setPostalCode($userAddrDto->getPostalCode());
            $user->setState($userAddrDto->getState());
            $user->setCountry($userAddrDto->getCountry());

        }
        if($userPayDto)
        {
            $user->setCcNumber($userPayDto->getCcNumber());
            $user->setCvv($userPayDto->getCvv());
            $user->setExpirationDate($userPayDto->getExpirationDate());
        }
        $this->em->persist($user);
        $this->em->flush();
        $this->addFlash(
            'notice',
            'Your changes were saved!'
        );
        $this->requestStack->getSession()->set('user-form-step-one', null);
        $this->requestStack->getSession()->set('user-form-step-two', null);
        $this->requestStack->getSession()->set('user-form-step-three', null);

        return $this->redirectToRoute('app_user_new', ['step' => 1]);
    }
}
