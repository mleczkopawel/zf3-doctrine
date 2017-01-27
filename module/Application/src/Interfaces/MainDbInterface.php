<?php
/**
 * User: mlecz
 * Date: 27.01.2017
 * Time: 15:27
 */

namespace Application\Interfaces;


interface MainDbInterface
{
    public function getId();
    public function setId($id);
    public function getName();
    public function setName($name);
}