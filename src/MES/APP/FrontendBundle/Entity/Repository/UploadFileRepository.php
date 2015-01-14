<?php
namespace MES\APP\FrontendBundle\Entity\Repository;

use DateTime;

class UploadFileRepository extends BaseRepository 
{
    public function findFilesOlderThan(DateTime $date)
    {
        $qb = $this
            ->createQueryBuilder('f')
            ->where('f.dateCreated < :date')
            ->setParameter('date', $date)
            ;
        
        return $qb->getQuery()->getResult();
    }
}