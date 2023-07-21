<?php

namespace App\Controller;

use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(TaskService $taskService): Response
    {
        $todoList = $taskService->getWeeklyPlan();
        $developers = $taskService->getDevelopers();

        return $this->render('home.html.twig', ['todoList' => $todoList, 'developers' => $developers]);
    }
}
