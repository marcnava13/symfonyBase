<?php 
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\GroupInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class Users extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_at", type="datetime")
     */
    private $modified_at;

    /**
     * @var integer
     *
     * @ORM\Column(name="created_by", type="integer")
     */
    private $createdBy;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->groups = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime $date
     *
     * @return User
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param \DateTime $date
     *
     * @return User
     */
    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Groups")
     * @ORM\JoinTable(name="fos_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Users
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set modifiedAt
     *
     * @param \DateTime $modifiedAt
     *
     * @return Users
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modified_at = $modifiedAt;

        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modified_at;
    }

    /**
     * Set createdBy
     *
     * @param integer $createdBy
     *
     * @return Users
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return integer
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set Salt
     *
     * @param \String $salt
     *
     * @return Users
     */
    public function setSalt($salt){
        $this->salt = $salt;

        return $this;
    }
    
}
