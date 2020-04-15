<?php


namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;


class PersonneRepository extends EntityRepository
{
    public function showMembers($id){
        $query = $this->createQueryBuilder('p')
            ->select('p.nom', 'p.prenom')
            ->innerJoin('GroupBundle:GroupPerson','gp',Join::WITH,'gp.idUtilisateur = p.idutilisateur')
            ->andWhere('gp.idGroup = :GID')
            ->setParameter('GID',$id);
        return $query->getQuery()->getResult();


    }


}