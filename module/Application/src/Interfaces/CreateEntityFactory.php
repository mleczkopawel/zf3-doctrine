<?php
/**
 * User: mlecz
 * Date: 27.01.2017
 * Time: 15:30
 */

namespace Application\Interfaces;

use Application\Entity\AL;
use Application\Entity\Album;

/**
 * Class CreateEntityFactory
 * @package Application\Interfaces
 */
class CreateEntityFactory implements AbstractFactory
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