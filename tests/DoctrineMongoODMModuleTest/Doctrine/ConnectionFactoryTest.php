<?php
namespace DoctrineMongoODMModuleTest\Service;

use DoctrineModule\Service\EventManagerFactory;
use DoctrineMongoODMModule\Service\ConfigurationFactory;
use DoctrineMongoODMModule\Service\ConnectionFactory;
use DoctrineMongoODMModuleTest\AbstractTest;

/**
 * Class ConnectionFactoryTest
 *
 * @author  Hennadiy Verkh <hv@verkh.de>
 * @covers  \DoctrineMongoODMModule\Service\ConnectionFactory
 */
class ConnectionFactoryTest extends AbstractTest
{
    private $configuration = [];

    private $connectionFactory = [];

    public function setup()
    {
        parent::setup();
        $this->serviceManager->setAllowOverride(true);
        $this->configuration     = $this->serviceManager->get('config');
        $this->connectionFactory = new ConnectionFactory('odm_default');
    }

    public function testConnectionStringOverwritesOtherConnectionSettings()
    {
        $connectionString = 'mongodb://localhost:27017';
        $connectionConfig = [
            'odm_default' => [
                'server'           => 'unreachable',
                'port'             => '10000',
                'connectionString' => $connectionString,
                'user'             => 'test fails if used',
                'password'         => 'test fails if used',
            ]
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $connection = $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($connectionString, $connection->__toString());
    }

    public function testConnectionStringShouldAllowMultipleHosts()
    {
        $unreachablePort  = 56000;
        $connectionString = "mongodb://localhost:$unreachablePort,localhost:27017";
        $connectionConfig = [
            'odm_default' => [
                'connectionString' => $connectionString,
            ]
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $connection = $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($connectionString, $connection->__toString());
    }

    public function testConnectionStringShouldAllowUnixSockets()
    {
        $connectionString = 'mongodb://' . rawurlencode('/tmp/mongodb-27017.sock');
        $connectionConfig = [
            'odm_default' => [
                'connectionString' => $connectionString,
            ]
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $connection = $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($connectionString, $connection->__toString());
    }

    public function testDbNameShouldSetDefaultDB()
    {
        $dbName  = 'foo_db';
        $connectionConfig = [
            'odm_default' => [
                'dbname' => $dbName,
            ]
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->configuration['doctrine']['configuration']['odm_default']['default_db'] = null;
        $this->serviceManager->setService('config', $this->configuration);

        $configurationFactory = new ConfigurationFactory('odm_default');
        $configuration = $configurationFactory->createService($this->serviceManager);
        $this->serviceManager->setService('doctrine.configuration.odm_default', $configuration);

        $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($dbName, $configuration->getDefaultDB());

    }

    public function testDbNameShouldNotOverrideExplicitDefaultDB()
    {
        $defaultDB  = 'foo_db';
        $connectionConfig = [
            'odm_default' => [
                'dbname' => rawurlencode('testFails'),
            ]
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $configuration = $this->serviceManager->get('doctrine.configuration.odm_default');
        $configuration->setDefaultDB($defaultDB);
        $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($defaultDB, $configuration->getDefaultDB());
    }

    public function testConnectionStringShouldSetDefaultDB()
    {
        $dbName  = 'foo_db';
        $connectionString = "mongodb://localhost:27017/$dbName";
        $connectionConfig = [
            'odm_default' => [
                'connectionString' => $connectionString,
            ]
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->configuration['doctrine']['configuration']['odm_default']['default_db'] = null;
        $this->serviceManager->setService('config', $this->configuration);

        $configurationFactory = new ConfigurationFactory('odm_default');
        $configuration = $configurationFactory->createService($this->serviceManager);
        $this->serviceManager->setService('doctrine.configuration.odm_default', $configuration);

        $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($dbName, $configuration->getDefaultDB());
    }

    public function testConnectionStringWithOptionsShouldSetDefaultDB()
    {
        $dbName  = 'foo_db';
        $connectionString = "mongodb://localhost:27017/$dbName";
        $connectionConfig = [
            'odm_default' => [
                'connectionString' => $connectionString,
            ]
        ];

        $this->configuration['doctrine']['connection'] = $connectionConfig;
        $this->configuration['doctrine']['configuration']['odm_default']['default_db'] = null;
        $this->serviceManager->setService('config', $this->configuration);

        $configurationFactory = new ConfigurationFactory('odm_default');
        $configuration = $configurationFactory->createService($this->serviceManager);
        $this->serviceManager->setService('doctrine.configuration.odm_default', $configuration);

        $this->connectionFactory->createService($this->serviceManager);

        $this->assertEquals($dbName, $configuration->getDefaultDB());
    }
}
