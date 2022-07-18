<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use phpdb\helper\EntityManagerFactory;

// replace with file to your own project bootstrap
require_once __DIR__ . "/vendor/autoload.php";

// replace with mechanism to retrieve EntityManager in your app
$entityManagerFactory = new EntityManagerFactory();
$entityManager = $entityManagerFactory->getEntityManeger();

return ConsoleRunner::createHelperSet($entityManager);
