<?php
/**
 * User controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\EditEmailType;
use App\Form\Type\EditPasswordType;
use App\Service\UserServiceInterface;
// use Symfony\Component\Form\Extension\Core\Type\FormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class UserController.
 */
#[Route('/user')]
#[IsGranted('ROLE_ADMIN')]
class UserController extends AbstractController
{
    /**
     * User service.
     */
    private UserServiceInterface $userService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param UserServiceInterface $userService User service
     * @param TranslatorInterface  $translator  Translator
     */
    public function __construct(UserServiceInterface $userService, TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->translator = $translator;
    }

    /**
     * Show action.
     *
     * @return Response HTTP response
     */
    #[Route(name: 'user_show')]
    public function show(): Response
    {
        $user = $this->getUser();

        return $this->render('user/show.html.twig', ['user' => $user]);
    }

    /**
     * Edit email action.
     *
     * @param Request $request HTTP request
     * @param User    $user    User entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/editEmail', name: 'user_editEmail', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function editEmail(Request $request, User $user): Response
    {
        $form = $this->createForm(
            EditEmailType::class,
            $user,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('user_editEmail', ['id' => $user->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->save($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('user_show');
        }

        return $this->render(
            'user/editEmail.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );
    }

    /**
     * Edit password action.
     *
     * @param Request $request HTTP request
     * @param User    $user    User entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/editPassword', name: 'user_editPassword', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function editPassword(Request $request, User $user): Response
    {
        $form = $this->createForm(
            EditPasswordType::class,
            $user,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('user_editPassword', ['id' => $user->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->save($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('user_show');
        }

        return $this->render(
            'user/editPassword.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );
    }
}
