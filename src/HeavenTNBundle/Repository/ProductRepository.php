<?php

namespace HeavenTNBundle\Repository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */

class ProductRepository extends \Doctrine\ORM\EntityRepository
{

    public function  findByIdproduct($id)
    {
        $query=$this->getEntityManager()->createQuery("SELECT m FROM HeavenTNBundle:Product m WHERE m.idProduct='$id' ");
        return $query->getResult();
    }
    public function findArray($array)
    {
        $qb = $this->createQueryBuilder('u')
            ->Select('u')->where('u.idproduct IN (:array)')
            ->setParameter('array',$array);
        return $qb->getQuery()->getResult();
    }

    public  function UpdateStock($id)
    {
        $qb = $this->createQueryBuilder('u')
            ->update('u')->where('u.idproduct = id')
            ->setParameter('id',$id);
    }



}