<?php
/**
 * User: Paweł Mleczko
 * Date: 13.02.2017
 * Time: 20:28
 */

namespace Admin;


/**
 * Class Module
 * @package Admin
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