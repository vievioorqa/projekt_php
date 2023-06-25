<?php
/**
 * Masterpiece controller.
 */

namespace App\Controller;

use App\Entity\Masterpiece;
use App\Form\Type\MasterpieceType;
use App\Service\MasterpieceServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class MasterpieceController.
 */
#[Route('/masterpiece')]
class MasterpieceController extends AbstractController
{
    /**
     * Masterpiece service.
     */
    private MasterpieceServiceInterface $masterpieceService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param MasterpieceServiceInterface $masterpieceService Masterpiece service
     * @param TranslatorInterface  $translator  Translator
     */
    public function __construct(MasterpieceServiceInterface $masterpieceService, TranslatorInterface $translator)
    {
        $this->masterpieceService = $masterpieceService;
        $this->translator = $translator;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'masterpiece_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->masterpieceService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('masterpiece/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Masterpiece $masterpiece Masterpiece entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}', name: 'masterpiece_show', requirements: ['id' => '[1-9]\d*'], methods: 'GET')]
    public function show(Masterpiece $masterpiece): Response
    {
        return $this->render('masterpiece/show.html.twig', ['masterpiece' => $masterpiece]);
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route('/create', name: 'masterpiece_create', methods: 'GET|POST', )]
    public function create(Request $request): Response
    {
        $masterpiece = new Masterpiece();
        $form = $this->createForm(
            MasterpieceType::class,
            $masterpiece,
            ['action' => $this->generateUrl('masterpiece_create')]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->masterpieceService->save($masterpiece);

            $this->addFlash(
                'success',
                $this->translator->trans('utworzono dzieło')
            );

            return $this->redirectToRoute('masterpiece_index');
        }

        return $this->render('masterpiece/create.html.twig',  ['form' => $form->createView()]);
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Masterpiece    $masterpiece    Masterpiece entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'masterpiece_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function edit(Request $request, Masterpiece $masterpiece): Response
    {
        $form = $this->createForm(
            MasterpieceType::class,
            $masterpiece,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('masterpiece_edit', ['id' => $masterpiece->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->masterpieceService->save($masterpiece);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('masterpiece_index');
        }

        return $this->render(
            'masterpiece/edit.html.twig',
            [
                'form' => $form->createView(),
                'masterpiece' => $masterpiece,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Masterpiece    $masterpiece    Masterpiece entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'masterpiece_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    public function delete(Request $request, Masterpiece $masterpiece): Response
    {
        $form = $this->createForm(
            FormType::class,
            $masterpiece,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('masterpiece_delete', ['id' => $masterpiece->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->masterpieceService->delete($masterpiece);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('masterpiece_index');
        }

        return $this->render(
            'masterpiece/delete.html.twig',
            [
                'form' => $form->createView(),
                'masterpiece' => $masterpiece,
            ]
        );
    }
}
