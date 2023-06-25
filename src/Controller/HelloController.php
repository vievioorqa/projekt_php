<?php
/**
 * Hello controller.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HelloController.
 */
#[Route('/hello')]
class HelloController extends AbstractController
{
    /**
     * Index action.
     *
     * @param string $name User input
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{name}',      //{} - zapis zmiennych
        name: 'hello_index',
        requirements: ['name' => '[a-zA-Z]+'],
        defaults: ['name' => 'World'],
        methods: 'GET'
    )]
    public function index(string $name): Response
    {
        if (isset($_GET['name'])) {
            $name = $_GET['name'];
        }

        return $this->render(       // $this to konkretny obiekt, tu:stworzony kontroller, którego używamy; $this->render wyświetla samego siebie
            'hello/index.html.twig',
            ['name' => $name]
        );
    }
}
