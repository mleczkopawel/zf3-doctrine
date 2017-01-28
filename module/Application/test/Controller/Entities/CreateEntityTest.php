<?php
/**
 * User: mlecz
 * Date: 27.01.2017
 * Time: 15:54
 */

namespace ApplicationTest\Controller\Entities;


use Application\Interfaces\CreateEntity;
use Application\Interfaces\CreateEntityFactory;
use PHPUnit_Framework_TestCase;

class CreateEntityTest extends PHPUnit_Framework_TestCase
{
    private $entities = [];

    /**
     * CreateEntityTest constructor.
     */
    public function __construct()
    {
        $this->entities = ['Album'];
    }


    public function testCreateEntityTest() {
        $createEntityFactory = new CreateEntityFactory();
        foreach ($this->entities as $entity) {
            $ent = $createEntityFactory->create($entity);
            $this->assertInstanceOf('Application\Entity\\' . $entity , $ent);
        }
    }
}