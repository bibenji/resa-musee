<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Person;

use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Resa
 *
 * @ORM\Table(name="resas")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Resa
{	
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	
	/**
	 * @ORM\Column(name="date_achat", type="datetime")
	 */
	private $dateAchat;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @var \Date
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="type_resa", type="string", length=2)
	 */
	private $typeResa;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=255)
	 */
	private $email;
	
	/**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;	
	
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=true)
     */
    private $code;	
	
	/**
	 * @ORM\ManyToMany(targetEntity="Person", cascade={"persist"}, inversedBy="resas")
     * @ORM\JoinTable(name="resa_persons",
     *      joinColumns={@ORM\JoinColumn(name="resa_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id", unique=true)}
     *      )
     */
	private $persons;	 



    public function __construct()
	{
		$this->persons = new ArrayCollection();
	}
	
	/**	 	 
	 * @ORM\PrePersist
	 */
	public function prePersistEvent()
	{
		$this->dateAchat = new \DateTime();		
	}
	
	/**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Resa
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Resa
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add person
     *
     * @param \AppBundle\Entity\Person $person
     *
     * @return Resa
     */
    public function addPerson(\AppBundle\Entity\Person $person)
    {
        $this->persons[] = $person;

        return $this;
    }

    /**
     * Remove person
     *
     * @param \AppBundle\Entity\Person $person
     */
    public function removePerson(\AppBundle\Entity\Person $person)
    {
        $this->persons->removeElement($person);
    }

    /**
     * Get persons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersons()
    {
        return $this->persons;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Resa
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set dateAchat
     *
     * @param \DateTime $dateAchat
     *
     * @return Resa
     */
    public function setDateAchat($dateAchat)
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    /**
     * Get dateAchat
     *
     * @return \DateTime
     */
    public function getDateAchat()
    {
        return $this->dateAchat;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Resa
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Resa
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set typeResa
     *
     * @param string $typeResa
     *
     * @return Resa
     */
    public function setTypeResa($typeResa)
    {
        $this->typeResa = $typeResa;

        return $this;
    }

    /**
     * Get typeResa
     *
     * @return string
     */
    public function getTypeResa()
    {
        return $this->typeResa;
    }
}
