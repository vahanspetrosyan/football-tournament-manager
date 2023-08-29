<?php

namespace App\Repository;

use App\Entity\FMatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FMatch>
 *
 * @method FMatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method FMatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method FMatch[]    findAll()
 * @method FMatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FMatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FMatch::class);
    }

    public function findMatchesByTournament($tournamentId)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.tournament = :tournamentId')
            ->setParameter('tournamentId', $tournamentId)
            ->orderBy('m.date', 'ASC') // Order matches by date in ascending order
            ->getQuery()
            ->getResult();
    }
}
