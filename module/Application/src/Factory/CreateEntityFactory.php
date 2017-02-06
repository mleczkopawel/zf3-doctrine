<?php
/**
 * User: mlecz
 * Date: 27.01.2017
 * Time: 15:30
 */

namespace Application\Factory;

use Application\Entity\Category;
use Application\Entity\File;
use Application\Entity\Product;
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
     * @return Category|File|Product|User|bool
     */
    public function create($entityName)
    {
        switch ($entityName) {
            case User::class: {
                return new User();
            } break;
            case File::class: {
                return new File();
            } break;
            case Category::class: {
                return new Category();
            } break;
            case Product::class: {
                return new Product();
            } break;
            default: {
                return false;
            }
        }
    }
}