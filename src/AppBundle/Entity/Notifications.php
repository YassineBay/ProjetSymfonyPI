<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notifications
 *
 * @ORM\Table(name="notifications", indexes={@ORM\Index(name="fk_foreign_key_idlivrasion", columns={"idLivraison"}), @ORM\Index(name="fkColis", columns={"idColis"}), @ORM\Index(name="fk_foreign_key_idLivreur", columns={"idLivreur"}), @ORM\Index(name="fk_foreign_key_idpropColis", columns={"idPropC"})})
 * @ORM\Entity
 */
class Notifications
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255, nullable=false)
     */
    private $content;

    /**
     * @var \Colis
     *
     * @ORM\ManyToOne(targetEntity="Colis")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idColis", referencedColumnName="id")
     * })
     */
    private $idcolis;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idLivreur", referencedColumnName="id")
     * })
     */
    private $idlivreur;

    /**
     * @var \Livraison
     *
     * @ORM\ManyToOne(targetEntity="Livraison")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idLivraison", referencedColumnName="id")
     * })
     */
    private $idlivraison;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPropC", referencedColumnName="id")
     * })
     */
    private $idpropc;


}

