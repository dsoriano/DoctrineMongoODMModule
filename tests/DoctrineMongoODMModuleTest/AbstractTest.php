<?php
namespace DoctrineMongoODMModuleTest;

use PHPUnit\Framework\TestCase;
use Zend\Mvc\Application;

abstract class AbstractTest extends TestCase
{
    protected $application;
    protected $serviceManager;

    public function setUp()
    {
        $this->application = Application::init(ServiceManagerFactory::getConfiguration());
        $this->serviceManager = $this->application->getServiceManager();
    }

    public function getDocumentManager()
    {
        return $this->serviceManager->get('doctrine.documentmanager.odm_default');
    }

    public function tearDown()
    {
        try {
            $client = $this->getDocumentManager()->getClient();
            $collections = $client->selectDatabase('doctrineMongoODMModuleTest')->listCollections();
            foreach ($collections as $collection) {
                if ($collection->getName() === 'system.indexes') {
                    continue;
                }
                $client->selectCollection('doctrineMongoODMModuleTest', $collection->getName())->drop();
            }
        } catch (\MongoException $e) {
        }
    }
}
