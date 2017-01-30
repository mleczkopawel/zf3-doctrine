<?php
/**
 * User: mlecz
 * Date: 27.01.2017
 * Time: 15:30
 */

namespace Application\Factory;

use Application\Entity\Album;
use Application\Entity\User;
use Application\Interfaces\CreateEntityInterface;

/**
 * Class CreateEntityFactory
 * @package Application\Interfaces
 */
class CreateEntityFactory implements CreateEntityInterface
{
    /**
     * @param $entityName
     * @return Album|User|bool
     */
    public function create($entityName) {
        switch ($entityName) {
            case Album::class: {
                return new Album();
            } break;
            case User::class: {
                return new User();
            }
             default: {
                return false;
            }
        }
    }
}