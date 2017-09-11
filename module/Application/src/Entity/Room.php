<?php
/**
 * Created by PhpStorm.
 * User: pawel
 * Date: 11.09.17
 * Time: 13:48
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Room
 * @package Application\Entity
 *
 * @ORM\Table(name="room")
 * @ORM\Entity(repositoryClass="Application\Entity\Repository\RoomRepository")
 */
class Room
{

    /**
     * @var array
     */
    private $types = [
        1 => 'Jednoosobowy',
        2 => 'Dwuosobowy - jedno łóżko',
        3 => 'Dwuosobowy - dwa łóżka',
        4 => 'Trzyosobowy - dwa łóżka',
        5 => 'Trzyosobowy - trzy łóżka',
        6 => 'Czteroosobowy - dwa łóżka',
        7 => 'Czteroosobowy - trzy łóżka',
        8 => 'Czteroosobowy - cztery łóżka',
    ];

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
     * @ORM\Column(name="name", type="string", nullable=true, length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=true, length=255)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_add", type="datetime", nullable=false)
     */
    private $dateAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_edit", type="datetime", nullable=true)
     */
    private $dateEdit;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_free", type="boolean", nullable=false)
     */
    private $isFree;

    /**
     * @ORM\ManyToMany(targetEntity="Application\Entity\File")
     * @ORM\JoinTable(name="rooms_photos",
     *      joinColumns={@ORM\JoinColumn(name="room_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="photo_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     * */
    private $photos;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Room
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
     * @return Room
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->types[$this->type];
    }

    /**
     * @param string $type
     * @return Room
     */
    public function setType($type)
    {
        $this->type = $type;
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
     * @return Room
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
     * @return Room
     */
    public function setDateEdit($dateEdit)
    {
        $this->dateEdit = $dateEdit;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFree()
    {
        return $this->isFree;
    }

    /**
     * @param bool $isFree
     * @return Room
     */
    public function setIsFree($isFree)
    {
        $this->isFree = $isFree;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @param mixed $photos
     * @return Room
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;
        return $this;
    }

    /**
     * @return array
     */
    public function getTypes() {
        return $this->types;
    }
}