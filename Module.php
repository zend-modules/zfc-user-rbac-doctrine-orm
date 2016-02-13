<?php
/**
 * Doctrine2 ORM storage adapter for ZfcUser and Rbac.
 *
 * @author    Juan Pedro Gonzalez Gutierrez
 * @link      http://github.com/zend-modules/zfc-user-rbac-doctrine-orm
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 */

namespace ZfcUserRbacDoctrineORM;

use Zend\Mvc\MvcEvent;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use ZfcUserRbacDoctrineORM\Listener\NavigationListener;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src',
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'zfcuser_doctrine_em' => 'Doctrine\ORM\EntityManager',
                'Zend\Authentication\AuthenticationService' => 'zfcuser_auth_service',
            ),
            'factories' => array(
                'zfcuser_module_options' => 'ZfcUserRbacDoctrineORM\Factory\ModuleOptionsFactory',
                'zfcuser_user_mapper'    => 'ZfcUserRbacDoctrineORM\Factory\UserMapperFactory',
                'zfcuser_role_mapper'    => 'ZfcUserRbacDoctrineORM\Factory\RoleMapperFactory',
                'ZfcUserRbacDoctrineORM\Listener\NavigationListener' => 'ZfcUserRbacDoctrineORM\Factory\NavigationListenerFactory',
            ),
        );
    }
    
    public function onBootstrap(MvcEvent $e)
    {
        /**
         * @var \Zend\Mvc\ApplicationInterface $app
         */
        $app     = $e->getParam('application');
        $sm      = $app->getServiceManager();
        $options = $sm->get('zfcuser_module_options');

        // Add the default entity driver only if specified in configuration
        if ($options->getEnableDefaultEntities()) {
            $chain = $sm->get('doctrine.driver.orm_default');
            $chain->addDriver(new XmlDriver(__DIR__ . '/config/xml/zfcuserrbacdoctrineorm'), 'ZfcUserRbacDoctrineORM\Entity');
        }
        
        $navListener = $sm->get('ZfcUserRbacDoctrineORM\Listener\NavigationListener');
        $navListener->attachShared($app->getEventManager()->getSharedManager());
    }
}