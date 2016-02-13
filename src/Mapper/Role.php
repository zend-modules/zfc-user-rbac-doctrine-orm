<?php
/**
 * Doctrine2 ORM storage adapter for ZfcUser and Rbac.
 *
 * @author    Juan Pedro Gonzalez Gutierrez
 * @link      http://github.com/zend-modules/zfc-user-rbac-doctrine-orm
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 */

namespace ZfcUserRbacDoctrineORM\Mapper;

use Zend\Stdlib\Hydrator\HydratorInterface;

class Role
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $em;
    
    /**
     * @var \ZfcUserRbacDoctrineORM\Options\ModuleOptions
     */
    protected $options;
    
    public function __construct(EntityManagerInterface $em, ModuleOptions $options)
    {
        $this->em      = $em;
        $this->options = $options;
    }

    public function findAll()
    {
        $er = $this->em->getRepository($this->options->getRoleEntityClass());
        return $er->findAll();
    }
    
    public function findByName($name)
    {
        $er = $this->em->getRepository($this->options->getRoleEntityClass());
    
        return $er->findOneBy(array('name' => $name));
    }
    
    public function findById($id)
    {
        $er = $this->em->getRepository($this->options->getRoleEntityClass());
    
        return $er->find($id);
    }

    public function insert($entity, $tableName = null, HydratorInterface $hydrator = null)
    {
        return $this->persist($entity);
    }

    public function update($entity, $where = null, $tableName = null, HydratorInterface $hydrator = null)
    {
        return $this->persist($entity);
    }

    protected function persist($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    
        return $entity;
    }
}