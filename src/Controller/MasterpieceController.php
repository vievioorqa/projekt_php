<?php
/**
 * Masterpiece controller.
 */

namespace App\Controller;

use App\Entity\Masterpiece;
use App\Service\CategoryServiceInterface;
use App\Service\MasterpieceServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
     * Constructor.
     */
    public function __construct(MasterpieceServiceInterface $masterpieceService)
    {
        $this->masterpieceService = $masterpieceService;
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

        dump($pagination);

        return $this->render('masterpiece/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Masterpiece $masterpiece Masterpiece entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'masterpiece_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(Masterpiece $masterpiece): Response
    {
        return $this->render('masterpiece/show.html.twig', ['masterpiece' => $masterpiece]);
    }
}
