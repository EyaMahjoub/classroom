<?php

namespace App\Controller;
use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Response\JsonMockResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
final class EnginantController extends AbstractController
{
    #[Route('/api/enginant', name: 'app_enginant')]
    public function index(): JsonResponse
    {
        $enginants=[
            ['id'=>1,'name'=>'Enginants A'],
            ['id' => 2, 'name' => 'Enginant B'],
        ];
      return $this->json( $enginants);
    }


}
