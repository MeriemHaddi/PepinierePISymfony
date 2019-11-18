<?php

namespace HeavenTNBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
* Event
*
 * @ORM\Table(name="event")
* @ORM\Entity
*/
class Event
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idevent", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idevent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startdate", type="datetime", nullable=true)
     *
     * @Assert\GreaterThanOrEqual("today")
     *
     * @Assert\NotBlank()
     *
     */
    private $startdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enddate", type="datetime", nullable=true)
     *
     * @Assert\GreaterThanOrEqual(propertyPath="startdate" )
     *
     * @Assert\NotBlank()
     *
     */
    private $enddate;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=45, nullable=true)
     *
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=45, nullable=true)
     *
     * @Assert\NotBlank()
     */
    private $address;
    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=45, nullable=true)
     */
    private $statut;
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=true)
     *
     * @Assert\NotBlank()
     */
    private $title;
    /**
     * @var integer
     *
     * @ORM\Column(name="NbrParticipant", type="integer")
     *
     * @Assert\GreaterThanOrEqual(
     *     value =0
     * )
     * @Assert\NotBlank()
     *
     */
    private $NbrParticipant;
    /**
     * @var integer
     *
     * @ORM\Column(name="NbrDesPlaces", type="integer", nullable=false)
     *
     * @Assert\GreaterThanOrEqual(
     *     value =0
     * )
     *
     * @Assert\GreaterThanOrEqual(propertyPath="NbrParticipant" )
     * @Assert\NotBlank()
     */
    private $NbrDesPlaces;

    /**
     * @var string
     *
     * @ORM\Column(name="eventavatar", type="string", length=255, nullable=true)
     */
    private $eventavatar;




    /**
     * Get idevent
     *
     * @return integer
     */
    public function getIdevent()
    {
        return $this->idevent;
    }

    /**
     * Set startdate
     *
     * @param \DateTime $startdate
     *
     * @return Event
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;

        return $this;
    }

    /**
     * Get startdate
     *
     * @return \DateTime
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Set enddate
     *
     * @param \DateTime $enddate
     *
     * @return Event
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;

        return $this;
    }

    /**
     * Get enddate
     *
     * @return \DateTime
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Event
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set nbrParticipant
     *
     * @param integer $nbrParticipant
     *
     * @return Event
     */
    public function setNbrParticipant($nbrParticipant)
    {
        $this->NbrParticipant = $nbrParticipant;

        return $this;
    }

    /**
     * Get nbrParticipant
     *
     * @return integer
     */
    public function getNbrParticipant()
    {
        return $this->NbrParticipant;
    }

    /**
     * Set nbrDesPlaces
     *
     * @param integer $nbrDesPlaces
     *
     * @return Event
     */
    public function setNbrDesPlaces($nbrDesPlaces)
    {
        $this->NbrDesPlaces = $nbrDesPlaces;

        return $this;
    }

    /**
     * Get nbrDesPlaces
     *
     * @return integer
     */
    public function getNbrDesPlaces()
    {
        return $this->NbrDesPlaces;
    }

    /**
     * Set eventavatar
     *
     * @param string $eventavatar
     *
     * @return Event
     */
    public function setEventavatar($eventavatar)
    {
        $this->eventavatar = $eventavatar;

        return $this;
    }

    /**
     * Get eventavatar
     *
     * @return string
     */
    public function getEventavatar()
    {
        return $this->eventavatar;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Event
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }
}
