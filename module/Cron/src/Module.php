<?php
/**
 * User: mlecz
 * Date: 07.02.2017
 * Time: 13:09
 */

namespace Cron;


/**
 * Class Module
 * @package Cron
 */
class Module
{
    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}