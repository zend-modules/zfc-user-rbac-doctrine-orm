<?php
/**
 * Doctrine2 ORM storage adapter for ZfcUser and Rbac.
 *
 * @author    Juan Pedro Gonzalez Gutierrez
 * @link      http://github.com/zend-modules/zfc-user-rbac-doctrine-orm
 * @copyright Copyright (c) 2016 Juan Pedro Gonzalez Gutierrez.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 */

namespace ZfcUserRbacDoctrineORM\Listener;

use Zend\EventManager\SharedListenerAggregateInterface;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\EventInterface;
use ZfcRbac\Service\AuthorizationService;
use Zend\Navigation\Page\AbstractPage;

class NavigationListener implements SharedListenerAggregateInterface
{
    /**
     * 
     * @var \ZfcRbac\Service\AuthorizationService
     */
    protected $authorizationService;

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = [];

    /** 
     * @var string
     */
    protected $id = 'Zend\View\Helper\Navigation\AbstractHelper';

    public function __construct(AuthorizationService $authorizationService)
    {
        $this->authorizationService = $authorizationService;
    }
    public function attachShared(SharedEventManagerInterface $events)
    {
        $this->listeners[] = $events->attach($this->id, 'isAllowed', array($this, 'isAllowed'));
    }
    
    public function detachShared(SharedEventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $callback) {
            if ($events->detach($id, $callback)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function isAllowed(EventInterface $event)
    {
        $target = $event->getTarget();
        if ($target instanceof \Zend\View\Helper\Navigation\AbstractHelper) {
            $page = $event->getParam('page');
            
            if (!$page instanceof AbstractPage) {
                return;
            }

            $permission = $page->getPermission();
            
            if (null === $permission) {
                return;
            }
            
            $event->stopPropagation();

            return $this->authorizationService->isGranted($permission);
        }
    }
}