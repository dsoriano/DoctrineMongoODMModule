<?php
namespace DoctrineMongoODMModuleTest\Doctrine;

use Doctrine\ODM\MongoDB\DocumentManager;
use DoctrineModule\Service\EventManagerFactory;
use DoctrineMongoODMModule\Service\DocumentManagerFactory;
use DoctrineMongoODMModuleTest\AbstractTest;

final class DocumentManagerTest extends AbstractTest
{
    private $configuration = [];

    public function setup()
    {
        parent::setup();
        $this->serviceManager->setAllowOverride(true);
        $this->configuration     = $this->serviceManager->get('config');
    }

    public function testDocumentManager()
    {
        $documentManager = $this->getDocumentManager();

        self::assertInstanceOf(DocumentManager::class, $documentManager);
    }

    public function testShouldSetEventManager()
    {
        $eventManagerConfig = [
            'odm_default' => [
                'subscribers' => [
                ],
            ]
        ];

        $this->configuration['doctrine']['eventmanager'] = $eventManagerConfig;
        $this->serviceManager->setService('config', $this->configuration);

        $eventManagerFactory = new EventManagerFactory('odm_default');
        $eventManager = $eventManagerFactory->createService($this->serviceManager);
        $this->serviceManager->setService('doctrine.eventmanager.odm_default', $eventManager);

        $documentManager = (new DocumentManagerFactory('odm_default'))->createService($this->serviceManager);

        self::assertSame($eventManager, $documentManager->getEventManager());
    }
}
