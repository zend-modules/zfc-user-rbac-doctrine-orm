<?php
/**
 * Doctrine2 ORM storage adapter for ZfcUser and Rbac.
 *
 * @author    Juan Pedro Gonzalez Gutierrez
 * @link      http://github.com/zend-modules/zfc-user-rbac-doctrine-orm
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 */

namespace ZfcUserRbacDoctrineORM\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcUserRbacDoctrineORM\Mapper\User;

class UserMapperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options \ZfcUserDoctrineORM\Options\ModuleOptions */
        $options = $serviceLocator->get('zfcuser_module_options');

        /* @var $entityManager \Doctrine\ORM\EntityManager */
        $entityManager = $serviceLocator->get('zfcuser_doctrine_em');

        $mapper = new User($entityManager, $options);

        return $mapper;
    }
}
