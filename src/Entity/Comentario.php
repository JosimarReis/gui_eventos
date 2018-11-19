<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComentarioRepository")
 */
class Comentario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $comentario;

    /**
     * @ORM\Column(type="datetime")
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="comentarios")
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comentario", inversedBy="resposta")
     */
    private $respostas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comentario", mappedBy="respostas")
     */
    private $resposta;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Evento", inversedBy="comentarios")
     */
    private $evento;


    public function __construct()
    {
        $this->resposta = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(string $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getRespostas(): ?self
    {
        return $this->respostas;
    }

    public function setRespostas(?self $respostas): self
    {
        $this->respostas = $respostas;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getResposta(): Collection
    {
        return $this->resposta;
    }

    public function addRespostum(self $respostum): self
    {
        if (!$this->resposta->contains($respostum)) {
            $this->resposta[] = $respostum;
            $respostum->setRespostas($this);
        }

        return $this;
    }

    public function removeRespostum(self $respostum): self
    {
        if ($this->resposta->contains($respostum)) {
            $this->resposta->removeElement($respostum);
            // set the owning side to null (unless already changed)
            if ($respostum->getRespostas() === $this) {
                $respostum->setRespostas(null);
            }
        }

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

  
}
