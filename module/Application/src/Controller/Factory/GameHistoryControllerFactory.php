<?php
namespace Application\Controller\Factory;


use Application\Controller\GameHistoryController;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;


/**
 * This is the factory for IndexController. Its purpose is to instantiate the
 * controller.
 */
class GameHistoryControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        // Instantiate the controller and inject dependencies
        return new GameHistoryController($entityManager);
    }
}