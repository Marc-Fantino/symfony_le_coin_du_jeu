<?php

namespace App\Repository;

use App\Entity\BluelineSymfony;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BluelineSymfony>
 *
 * @method BluelineSymfony|null find($id, $lockMode = null, $lockVersion = null)
 * @method BluelineSymfony|null findOneBy(array $criteria, array $orderBy = null)
 * @method BluelineSymfony[]    findAll()
 * @method BluelineSymfony[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BluelineSymfonyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BluelineSymfony::class);
    }

    public function add(BluelineSymfony $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BluelineSymfony $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return BluelineSymfony[] Returns an array of BluelineSymfony objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BluelineSymfony
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function getDernierProduit(){
    
    //Ici on cr??er une variable qui appel la m??thode creatQueryBuilder de doctrine et prend un alias en param??tre
    //De cette maniere pas besoin d'??crire de SQL classique
    //A noter que PHP permet de chainer les m??thodes
    $dernierProduit = $this->createQueryBuilder('p')
    //on utilise l'alias p pour recup??rer l'id et trier par ordre decroissant
    ->OrderBy ('p.id', 'DESC')
    //Un seul element
    ->setMaxResults(1)
    //Parcours des resultats
    ->getQuery()
    //getonenullresult() = recup??re un objet ou une valeur null (erreur si plusieurs objets)
    ->getOneOrNullResult();
    //retourne le resutltat de ma requ??te
    return $dernierProduit;
    }
}
