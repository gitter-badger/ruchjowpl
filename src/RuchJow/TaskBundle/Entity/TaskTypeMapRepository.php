<?php

namespace RuchJow\TaskBundle\Entity;

use Doctrine\ORM\EntityRepository;
use RuchJow\UserBundle\Entity\User;

/**
 * TaskTypeMapRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TaskTypeMapRepository extends EntityRepository
{

    /**
     * @param $type
     *
     * @return User[]
     */
    public function findByType($type, $includeAdmins = false)
    {

        $qb = $this->createQueryBuilder('ttm');

        $qb->join('ttm.user', 'u')
            ->addSelect('u')
            ->andWhere($qb->expr()->eq('ttm.type', ':type'))
            ->setParameter('type', $type)
            ->distinct(true);

        if ($includeAdmins) {
            $qb
                ->orWhere($qb->expr()->eq('ttm.type', ':all_type'))
                ->setParameter('all_type', TaskTypeMap::TYPE_ALL);
        }

        /** @var TaskTypeMap[] $ttms */
        $ttms = $qb->getQuery()->getResult();

        $users = array();
        foreach ($ttms as $ttm) {
            $id = $ttm->getUser()->getId();
            if (!isset($user[$id])) {
                $users[$id] = $ttm->getUser();
            }
        }

        return $users;
    }
}