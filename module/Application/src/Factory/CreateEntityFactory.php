<?php
/**
 * User: mlecz
 * Date: 27.01.2017
 * Time: 15:30
 */

namespace Application\Factory;

use Application\Entity\Album;
use Application\Interfaces\AbstractFactoryInterface;

/**
 * Class CreateEntityFactory
 * @package Application\Interfaces
 */
class CreateEntityFactory implements AbstractFactoryInterface
{
    /**
     * @return Album|bool
     */
    public function create($entityName) {
        switch ($entityName) {
            case Album::class: {
                return new Album();
            } break;
            default: {
                return false;
            }
        }
    }
}