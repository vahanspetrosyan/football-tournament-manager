<?php
namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Team;
use App\Form\TeamType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ManagerRegistry $managerRegistry;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $managerRegistry)
    {
        $this->entityManager = $entityManager;
        $this->managerRegistry = $managerRegistry;
    }

    #[Route('/teams', name: 'team_list')]
    public function index(): Response
    {
        $teamRepository = $this->entityManager->getRepository(Team::class);
        $teams = $teamRepository->findAll();

        return $this->render('team/index.html.twig', [
            'teams' => $teams,
        ]);
    }

    #[Route('/teams/create', name: 'team_create')]
    public function create(Request $request): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('team_list');
        }

        return $this->render('team/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/teams/{id}/delete', name: 'team_delete')]
    public function delete(Request $request, Team $team): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->get('token'))) {
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->remove($team);
            $entityManager->flush();
        }

        return $this->redirectToRoute('team_list');
    }
}
