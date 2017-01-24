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
	public function validateDate(ExecutionContextInterface $context, $payload)
	{
		// date doit être un jour d'ouverture du musée
		// billets ne peuvent pas être journée si 14h passées
		// créer tout ça dans des contraintes extérieures
		if (empty($this->persons)) {
			$context
				->buildViolation('Personne d\'enregistré pour la visite !')
                ->atPath('persons')
                ->addViolation();
		}
	}
	
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
	 * @ORM\Column(name="type", type="string", length=2)
	 */
	private $type;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=255)
	 */
	private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="confirmed", type="boolean", nullable=true)
     */
    private $confirmed;	
	
	/**
	 * @ORM\ManyToMany(targetEntity="Person", cascade={"persist"})
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
     * Set confirmed
     *
     * @param boolean $confirmed
     *
     * @return Resa
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    /**
     * Get confirmed
     *
     * @return bool
     */
    public function getConfirmed()
    {
        return $this->confirmed;
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
     * Set type
     *
     * @param string $type
     *
     * @return Resa
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
}
