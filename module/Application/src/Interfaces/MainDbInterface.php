<?php
/**
 * User: mlecz
 * Date: 27.01.2017
 * Time: 15:27
 */

namespace Application\Interfaces;


/**
 * Interface MainDbInterface
 * @package Application\Interfaces
 */
interface MainDbInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param $id
     * @return mixed
     */
    public function setId($id);

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param $name
     * @return mixed
     */
    public function setName($name);

    /**
     * @return mixed
     */
    public function getDateAdd();

    /**
     * @param $date
     * @return mixed
     */
    public function setDateAdd($date);

    /**
     * @return mixed
     */
    public function getDateEdit();

    /**
     * @param $date
     * @return mixed
     */
    public function setDateEdit($date);

}