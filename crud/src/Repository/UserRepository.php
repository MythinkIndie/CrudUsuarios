<?php
    namespace App\Repository;

    use App\Entity\User;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    class UserRepository extends ServiceEntityRepository {

        public function __construct(ManagerRegistry $registry) {

            parent::__construct($registry, User::class);

        }

        public function searchUsers(string $term): array {
            return $this->createQueryBuilder('u')
                ->where('u.name LIKE :term OR u.email LIKE :term OR u.phone LIKE :term')
                ->setParameter('term', '%'.$term.'%')
                ->getQuery()
                ->getResult();
        }

    }