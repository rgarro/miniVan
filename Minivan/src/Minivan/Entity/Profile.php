<?php
namespace Minivan\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 *
 * @ORM\Entity
 * @ORM\Table(name="profile")
 *
 * @author Rolando <rgarro@gmail.com>
 */
class Profile
{

    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
 	* @ORM\GeneratedValue(strategy="AUTO")
 	*/
    protected $id;
	
    /**
    * @ORM\Column(type="string")
 	*/
    protected $email;
	
	/**
    * @ORM\Column(type="string")
 	*/
    protected $resource;

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }
	
	public function getResource()
    {
        return $this->resource;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
    }
	
	public function setEmail($email)
    {
        $this->email = $email;
    }
}