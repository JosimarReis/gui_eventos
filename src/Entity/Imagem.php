<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ImagemRepository")
 */
class Imagem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Por favor selecione uma imagem.")
     * @Assert\File(mimeTypes={ "image/*" })
     */
    private $imagem;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Evento", inversedBy="imagens")
     */
    private $evento;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImagem()
    {
        return $this->imagem;
    }

    public function setImagem($imagem): self
    {
        $this->imagem = $imagem;

        return $this;
    }
   
    public function getEvento(): ?Evento
    {
        return $this->evento;
    }

    public function setEvento(?Evento $evento): self
    {
        $this->evento = $evento;

        return $this;
    }

    /**
 * Set images
 *
 * @param string $images
 *
 * @return satelliteImage[]
 */
public function setImages($images)
{
    $this->images = $images;

    return $this;
}

/**
 * Get images
 *
 * @return string
 */
public function getImages()
{
    return $this->image;
}

public function addImage($image)
{
    $this->images[] = $image;

    return $this;
}
}
