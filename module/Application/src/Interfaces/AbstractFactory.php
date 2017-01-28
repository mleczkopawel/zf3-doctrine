<?php
/**
 * User: mlecz
 * Date: 27.01.2017
 * Time: 15:30
 */

namespace Application\Interfaces;


/**
 * Interface AbstractFactory
 * @package Application\Interfaces
 */
interface AbstractFactory
{
    /**
     * @param $entityName
     * @return mixed
     */
    public function create($entityName);
}