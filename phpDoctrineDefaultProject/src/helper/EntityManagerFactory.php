<?php
namespace phpdb\helper;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class EntityManagerFactory
{
    public function getEntityManeger()
    {
        $rootDir = __DIR__ . "../../";
        $connection = [
            'driver' => 'pdo_sqlite',
            'path' => $rootDir . '/var/data/phpdb.db',
        ];

        $config = Setup::createAnnotationMetadataConfiguration(
            [$rootDir . ''],
            true
        );

        return EntityManager::create($connection, $config);
    }
}
