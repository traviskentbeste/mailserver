<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alias
 *
 * @ORM\Table(name="alias", indexes={@ORM\Index(name="IDX_E16C6B94A76ED395", columns={"user_id"})})
 * @ORM\Entity
 */
class Alias
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128, nullable=false)
     */
    private $email;

    /**
     * @var \Application\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


    /**
     * Set id.
     *
     * @param string|null $id
     *
     * @return Alias
     */
    public function setId($id = null)
    {
    	$this->id = $id;
    
    	return $this;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Alias
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set user.
     *
     * @param \Application\Entity\User|null $user
     *
     * @return Alias
     */
    public function setUser(\Application\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \Application\Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {

        return [
            'id' => $this->getId(),
            'user' => $this->getUser(),
            'email' => $this->getEmail()
        ];

    }

    /**
     * @param $data
     */
    public function exchangeArray($data)
    {

        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->user = (isset($data['user'])) ? $data['user'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;

    }

}
