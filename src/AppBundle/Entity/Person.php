<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="persons")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonRepository")
 */
class Person
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
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var int
     *
     * @ORM\Column(name="reduction", type="integer", nullable=true)
     */
    private $reduction;
	
	/**
	* @ORM\ManyToMany(targetEntity="Resa", mappedBy="persons")
	*/
	private $resas;


	
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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Person
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Person
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Person
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set reduction
     *
     * @param integer $reduction
     *
     * @return Person
     */
    public function setReduction($reduction)
    {
        $this->reduction = $reduction;

        return $this;
    }

    /**
     * Get reduction
     *
     * @return int
     */
    public function getReduction()
    {
        return $this->reduction;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->resas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add resa
     *
     * @param \AppBundle\Entity\Resa $resa
     *
     * @return Person
     */
    public function addResa(\AppBundle\Entity\Resa $resa)
    {
        $this->resas[] = $resa;

        return $this;
    }

    /**
     * Remove resa
     *
     * @param \AppBundle\Entity\Resa $resa
     */
    public function removeResa(\AppBundle\Entity\Resa $resa)
    {
        $this->resas->removeElement($resa);
    }

    /**
     * Get resas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResas()
    {
        return $this->resas;
    }
}
