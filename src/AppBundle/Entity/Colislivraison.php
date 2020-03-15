<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Colislivraison
 *
 * @ORM\Table(name="colislivraison", indexes={@ORM\Index(name="IDX_533EE04050CF9CE4", columns={"idColis"})})
 * @ORM\Entity
 */
class Colislivraison
{
    /**
     * @var integer
     *
     * @ORM\Column(name="livraison", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $livraison;

    /**
     * @var \Colis
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Colis")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idColis", referencedColumnName="id")
     * })
     */
    private $idcolis;


}

