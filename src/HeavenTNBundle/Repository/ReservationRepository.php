<?php

namespace HeavenTNBundle\Repository;

/**
 * RatingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReservationRepository extends \Doctrine\ORM\EntityRepository
{



    public function Trend()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
        SELECT u FROM HeavenTNBundle:Reservation p inner join PubliciteBundle:Publicite u
        WHERE p.datedebut < CURRENT_DATE()
        AND p.datefin > CURRENT_DATE ()
        AND p.position = 1
        AND u.etat = 1
        WHERE p.user=u.user
    ')
        ;


        return $query->getResult();
    }

    public function Trend2()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
        SELECT u FROM HeavenTNBundle:Reservation p inner join PubliciteBundle:Publicite u
        WHERE p.datedebut < CURRENT_DATE()
        AND p.datefin > CURRENT_DATE ()
        AND p.position = 2
        AND u.etat = 1
        WHERE p.user=u.user
    ')
        ;


        return $query->getResult();
    }
    public function Trend3()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
        SELECT u FROM HeavenTNBundle:Reservation p inner join PubliciteBundle:Publicite u
        WHERE p.datedebut < CURRENT_DATE()
        AND p.datefin > CURRENT_DATE ()
        AND p.position = 3
        AND u.etat = 1
        WHERE p.user=u.user
    ')
        ;


        return $query->getResult();
    }

    public function Trend4()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
        SELECT u FROM HeavenTNBundle:Reservation p inner join PubliciteBundle:Publicite u
        WHERE p.datedebut < CURRENT_DATE()
        AND p.datefin > CURRENT_DATE ()
        AND p.position = 4
        AND u.etat = 1
        WHERE p.user=u.user
    ')
        ;


        return $query->getResult();
    }

    public function Trend5()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
        SELECT u FROM HeavenTNBundle:Reservation p inner join PubliciteBundle:Publicite u
        WHERE p.datedebut < CURRENT_DATE()
        AND p.datefin > CURRENT_DATE ()
        AND p.position = 5
        AND u.etat = 1
        WHERE p.user=u.user
    ')
        ;


        return $query->getResult();
    }
}





