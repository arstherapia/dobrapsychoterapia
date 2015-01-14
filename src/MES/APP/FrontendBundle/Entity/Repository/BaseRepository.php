<?php

namespace MES\APP\FrontendBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class BaseRepository extends EntityRepository {

    public function count() {
        $qb = $this->createQueryBuilder('c')
                ->select('count(c.id)')
        ;

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countByParameters(FindParametersInterface $params) {
        $qb = $this->createQueryBuilder('c')
                ->select('count(c.id)')
        ;

        $params->applyParametersToQuery($qb);

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param FindParametersInterface $params
     * @return FindResult
     */
    public function findByParameters(FindParametersInterface $params) {
        $qb = $this->createQueryBuilder('c')
                ->select('c')
        ;

        $params->applyParametersToQuery($qb);

        return new FindResult($qb);
    }

}
