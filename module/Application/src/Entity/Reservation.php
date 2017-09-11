<?php
/**
 * Created by PhpStorm.
 * User: pawel
 * Date: 11.09.17
 * Time: 14:00
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Reservation
 * @package Application\Entity
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="Application\Entity\Repository\ReservationRepository")
 */
class Reservation
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
     * @ORM\ManyToOne(targetEntity="Application\Entity\Room")
     * @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     */
    private $room;

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
     * @ORM\Column(name="date_reservation_start", type="datetime", nullable=false)
     */
    private $dateReservationStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reservation_end", type="datetime", nullable=false)
     */
    private $dateReservationEnd;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_accepted", type="boolean", nullable=false)
     */
    private $accepted;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Reservation
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param mixed $room
     * @return Reservation
     */
    public function setRoom($room)
    {
        $this->room = $room;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Reservation
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * @return Reservation
     */
    public function setDateAdd($dateAdd)
    {
        $this->dateAdd = $dateAdd;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateReservationStart()
    {
        return $this->dateReservationStart;
    }

    /**
     * @param \DateTime $dateReservationStart
     * @return Reservation
     */
    public function setDateReservationStart($dateReservationStart)
    {
        $this->dateReservationStart = $dateReservationStart;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateReservationEnd()
    {
        return $this->dateReservationEnd;
    }

    /**
     * @param \DateTime $dateReservationEnd
     * @return Reservation
     */
    public function setDateReservationEnd($dateReservationEnd)
    {
        $this->dateReservationEnd = $dateReservationEnd;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAccepted()
    {
        return $this->accepted;
    }

    /**
     * @param bool $accepted
     * @return Reservation
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;
        return $this;
    }
}