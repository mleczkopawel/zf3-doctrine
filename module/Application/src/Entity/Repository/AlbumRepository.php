<?php
/**
 * User: mlecz
 * Date: 27.01.2017
 * Time: 14:16
 */

namespace Application\Entity\Repository;


use Application\Entity\Album;
use Doctrine\ORM\EntityRepository;

class AlbumRepository extends EntityRepository
{
    public function getY() {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb->select('a.name')->from(Album::class, 'a')->where('a.id = 1');
        $query = $qb->getQuery();

        return $query->getResult();
    }

}