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
use ZfcUserRbacDoctrineORM\Listener\NavigationListener;

class NavigationListenerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authorizationService = $serviceLocator->get('ZfcRbac\Service\AuthorizationService');
 
        return new NavigationListener($authorizationService);
    }
}