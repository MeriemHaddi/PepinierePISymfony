<?php

namespace HeavenTNBundle\Repository;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByStatut($statut)
    {

        $query=$this->getEntityManager()->createQuery("SELECT m FROM HeavenTNBundle:Event m WHERE m.statut='$statut' ");
        return $query->getResult();
    }
}