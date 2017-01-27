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
 * Class CreateEntity
 * @package Application\Interfaces
 */
class CreateEntity implements AbstractFactory
{
    /**
     * @return AL|Album|bool
     */
    public function create($entityName) {
        switch ($entityName) {
            case 'Album': {
                return new Album();
            } break;
            case 'AL': {
                return new AL();
            } break;
            default: {
                return false;
            }
        }
    }
}