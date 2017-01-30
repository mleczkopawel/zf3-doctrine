<?php
/**
 * User: mlecz
 * Date: 30.01.2017
 * Time: 15:17
 */

namespace Application\Entity;

use Application\Interfaces\MainDbInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Application\Entity\Repository\UserRepository")
 */
class User implements MainDbInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, length=11)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false, length=255)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", nullable=false, length=255)
     */
    private $password;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", nullable=false, length=255)
     */
    private $email;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_add", type="datetime", nullable=false)
     */
    private $dateAdd;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_edit", type="datetime", nullable=false)
     */
    private $dateEdit;
    /**
     * @var int
     *
     * @ORM\Column(name="google", type="integer", nullable=true)
     */
    private $google;
    /**
     * @var int
     *
     * @ORM\Column(name="facebook", type="integer", nullable=true)
     */
    private $facebook;
    /**
     * @var int
     *
     * @ORM\Column(name="local", type="integer", nullable=true)
     */
    private $local;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param int $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateAdd()
    {
        return $this->dateAdd;
    }

    /**
     * @param \DateTime $dateAdd
     * @return User
     */
    public function setDateAdd($dateAdd)
    {
        $this->dateAdd = $dateAdd;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateEdit()
    {
        return $this->dateEdit;
    }

    /**
     * @param \DateTime $dateEdit
     * @return User
     */
    public function setDateEdit($dateEdit)
    {
        $this->dateEdit = $dateEdit;
        return $this;
    }

    /**
     * @return int
     */
    public function getGoogle()
    {
        return $this->google;
    }

    /**
     * @param int $google
     * @return User
     */
    public function setGoogle($google)
    {
        $this->google = $google;
        return $this;
    }

    /**
     * @return int
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param int $facebook
     * @return User
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
        return $this;
    }

    /**
     * @return int
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * @param int $local
     * @return User
     */
    public function setLocal($local)
    {
        $this->local = $local;
        return $this;
    }

    public function setProvider($provider) {
        switch ($provider) {
            case 'facebook': {
                $this->setFacebook(1);
            } break;
            case 'google': {
                $this->setGoogle(1);
            } break;
            case 'local': {
                $this->setLocal(1);
            } break;
        }
    }
}