<?php
namespace DoctrineMongoODMModuleTest\Doctrine;

use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use DoctrineMongoODMModuleTest\AbstractTest;

class AnnotationTest extends AbstractTest
{
    public function testAnnotation()
    {
        $documentManager = $this->getDocumentManager();
        $metadata = $documentManager->getClassMetadata('DoctrineMongoODMModuleTest\Assets\Document\Annotation');

        $this->assertInstanceOf(ClassMetadata::class, $metadata);

        $fieldMappingId = $metadata->getFieldMapping('id');
        $this->assertIsArray($fieldMappingId);
        $this->assertSame('UUID', $fieldMappingId['strategy']);

        $fieldMappingName = $metadata->getFieldMapping('name');
        $this->assertIsArray($fieldMappingName);
        $this->assertSame('string', $fieldMappingName['type']);
    }
}
