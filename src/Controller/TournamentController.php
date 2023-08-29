<?php
namespace App\Controller;

use App\Entity\FMatch;
use App\Entity\Team;
use App\Entity\Tournament;
use App\Form\TournamentType;
use App\Repository\FMatchRepository;
use App\Service\MatchScheduler;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TournamentController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ManagerRegistry $managerRegistry;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $managerRegistry)
    {
        $this->entityManager = $entityManager;
        $this->managerRegistry = $managerRegistry;
    }

    #[Route('/tournaments', name: 'tournaments_list')]
    public function index(): Response
    {
        $tournaments = $this->entityManager->getRepository(Tournament::class)->findAll();

        return $this->render('tournament/index.html.twig', [
            'tournaments' => $tournaments,
        ]);
    }

    #[Route('/tournaments/create', name: 'tournament_create')]
    public function create(Request $request): Response
    {
        $tournament = new Tournament();
        $form = $this->createForm(TournamentType::class, $tournament);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager = $this->managerRegistry->getManager();
                $teams = $this->entityManager->getRepository(Team::class)->findAll();

                $matchesByDay = MatchScheduler::scheduler($teams);

                foreach($matchesByDay as $day => $matches) {
                    foreach($matches as $match) {
                        $fMatch = new FMatch();
                        $fMatch->setTeam1($this->entityManager->getRepository(Team::class)->find($match["Home"]->getId()));
                        $fMatch->setTeam2($this->entityManager->getRepository(Team::class)->find($match["Away"]->getId()));
                        $fMatch->setDate(new \DateTime('+ ' . $day . ' days'));
                        $fMatch->setTournament($tournament);
                        $entityManager->persist($fMatch);
                    }
                }

                $entityManager->persist($tournament);
                $entityManager->flush();

                $this->addFlash('success', 'Tournament added successfully.');
                return $this->redirectToRoute('tournaments_list');
            } catch (UniqueConstraintViolationException $e) {
                $errorMessage = 'The tournament name is already taken. Please choose a different name.';
                return $this->render('tournament/create.html.twig', [
                    'form' => $form->createView(),
                    'error' => $errorMessage,
                ]);
            } catch (\Exception $e) {
                return $this->render('tournament/create.html.twig', [
                    'form' => $form->createView(),
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $this->render('tournament/create.html.twig', [
            'form' => $form->createView(),
            'error' => false
        ]);
    }

    #[Route('/tournaments/{id}/delete', name: 'tournament_delete')]
    public function delete(Request $request, Tournament $tournament): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tournament->getId(), $request->get('token'))) {
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->remove($tournament);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tournaments_list');
    }

    #[Route('/tournaments/{slug}', name: 'tournament_view')]
    public function view(Tournament $tournament, FMatchRepository $matchRepository): Response
    {
        // Get the ordered matches for the tournament
        $matches = $matchRepository->findMatchesByTournament($tournament->getId());

        return $this->render('tournament/matches.html.twig', [
            'tournament' => $tournament,
            'matches' => $matches,
        ]);
    }
}
