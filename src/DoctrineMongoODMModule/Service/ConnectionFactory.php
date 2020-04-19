<?php
namespace DoctrineMongoODMModule\Service;

use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineMongoODMModule\Options;
use Interop\Container\ContainerInterface;
use MongoDB\Client;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory creates a mongo connection
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class ConnectionFactory extends AbstractFactory
{
    /**
     * {@inheritDoc}
     *
     * @return Client
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var $options Options\Connection */
        $options = $this->getOptions($container, 'connection');

        $connectionString = $options->getConnectionString();
        $dbName = null;

        if (empty($connectionString)) {
            $connectionString = 'mongodb://';

            $user     = $options->getUser();
            $password = $options->getPassword();
            $dbName   = $options->getDbName();

            if ($user && $password) {
                $connectionString .= $user . ':' . $password . '@';
            }

            $connectionString .= $options->getServer() . ':' . $options->getPort();

            if ($dbName) {
                $connectionString .= '/' . $dbName;
            }
        } else {
            // parse dbName from the connectionString
            $dbStart = strpos($connectionString, '/', 11);
            if (false !== $dbStart) {
                $dbEnd = strpos($connectionString, '?');
                $dbName = substr(
                    $connectionString,
                    $dbStart + 1,
                    $dbEnd ? ($dbEnd - $dbStart - 1) : PHP_INT_MAX
                );
            }
        }

        /** @var $configuration Configuration */
        $configuration = $container->get('doctrine.configuration.' . $this->getName());

        // Set defaultDB to $dbName, if it's not defined in configuration
        if (null === $configuration->getDefaultDB()) {
            $configuration->setDefaultDB($dbName);
        }

        return new Client($connectionString, [], ['typeMap' => DocumentManager::CLIENT_TYPEMAP]);
    }

    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, Client::class);
    }

    /**
     * Get the class name of the options associated with this factory.
     *
     * @return string
     */
    public function getOptionsClass()
    {
        return Options\Connection::class;
    }
}
