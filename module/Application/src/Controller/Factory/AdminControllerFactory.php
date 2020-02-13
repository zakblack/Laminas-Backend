<?php
namespace Application\Controller\Factory;

use Application\Controller\AdminController;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Session\SessionManager;


/**
 * This is the factory for IndexController. Its purpose is to instantiate the
 * controller.
 */
class AdminControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $sessionManager = $container->get(SessionManager::class);

        // Instantiate the controller and inject dependencies
        return new AdminController($entityManager, $sessionManager);
    }
}