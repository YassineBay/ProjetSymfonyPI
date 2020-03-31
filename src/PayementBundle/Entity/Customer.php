<?php

namespace PayementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;
use AppBundle\Entity\Notifications;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity
 */
class Customer implements NotifiableInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=50, nullable=false)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="FullName", type="string", length=255, nullable=false)
     */
    private $fullname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime", nullable=false)
     */
    private $datecreation = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @param string $fullname
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
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
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return \DateTime
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * @param \DateTime $datecreation
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;
    }

    public function notificationsOnCreate(NotificationBuilder $builder)
    {
        $notification = new Notifications();
        $notification->setTitle("new customer")
            ->setDescription("$this->fullname")
            ->setRoute('show')
            ->setParameters(array('id'=>$this->id));
        $builder->addNotification($notification);
        return $builder;
    }

    public function notificationsOnUpdate(NotificationBuilder $builder)
    {
        // TODO: Implement notificationsOnUpdate() method.
    }

    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        // TODO: Implement notificationsOnDelete() method.
    }


}

