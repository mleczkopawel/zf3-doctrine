<?php
/**
 * User: mlecz
 * Date: 27.01.2017
 * Time: 15:30
 */

namespace Application\Interfaces;


interface AbstractFactory
{
    public function create($entityName);
}