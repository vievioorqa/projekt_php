<?php
/**
 * Record controller
 */

namespace App\Controller;

use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RecordController.
 */
#[Route('/record')] //ścieżka /record ma nazwę 'record_index' co jest zapisane w dalszej czesci #[Route
class RecordController extends AbstractController
{
    /**
     * Index action. wyswietla cala tabelke
     *
     * @param RecordRepository $repository Record repository
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'record_index',
        methods: 'GET'
    )]
    public function index(RecordRepository $repository): Response
    {
        $records = $repository->findAll();

        return $this->render(
            'record/index.html.twig',
            ['records' => $records]
        );
    }

    /**
     * Show action. wyswietla konkretny rekord
     *
     * @param RecordRepository $repository Record repository
     * @param int              $id         Record id
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'record_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(RecordRepository $repository, int $id): Response
    {
        $record = $repository->findOneById($id);

        return $this->render(
            'record/show.html.twig',
            ['record' => $record]
        );
    }
}
