<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventoRepository")
 */
class Evento
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank
     */
    private $nome;

    /**
     * @ORM\Column(type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     * @Assert\NotBlank
     */
    private $data;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $descricao;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="eventos")
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categoria", inversedBy="eventos")
     * @Assert\NotBlank
     */
    private $categoria;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Local", inversedBy="eventos")
     * @Assert\NotBlank
     */
    private $local;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     * 
     */
    private $visitas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Imagem", mappedBy="evento")
     */
    private $imagens;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comentario", mappedBy="evento")
     */
    private $comentarios;

    public function __construct()
    {
        $this->imagens = new ArrayCollection();
        $this->comentarios = new ArrayCollection();
        $this->data =  new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

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

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

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

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getLocal(): ?Local
    {
        return $this->local;
    }

    public function setLocal(?Local $local): self
    {
        $this->local = $local;

        return $this;
    }

    public function getVisitas(): ?int
    {
        return $this->visitas;
    }

    public function setVisitas(int $visitas): self
    {
        $this->visitas = $visitas;

        return $this;
    }

    /**
     * @return Collection|Imagem[]
     */
    public function getImagens(): Collection
    {
        return $this->imagens;
    }

    public function addImagen(Imagem $imagen): self
    {
        if (!$this->imagens->contains($imagen)) {
            $this->imagens[] = $imagen;
            $imagen->setEvento($this);
        }

        return $this;
    }

    public function removeImagen(Imagem $imagen): self
    {
        if ($this->imagens->contains($imagen)) {
            $this->imagens->removeElement($imagen);
            // set the owning side to null (unless already changed)
            if ($imagen->getEvento() === $this) {
                $imagen->setEvento(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comentario[]
     */
    public function getComentarios(): Collection
    {
        return $this->comentarios;
    }

    public function addComentario(Comentario $comentario): self
    {
        if (!$this->comentarios->contains($comentario)) {
            $this->comentarios[] = $comentario;
            $comentario->setEvento($this);
        }

        return $this;
    }

    public function removeComentario(Comentario $comentario): self
    {
        if ($this->comentarios->contains($comentario)) {
            $this->comentarios->removeElement($comentario);
            // set the owning side to null (unless already changed)
            if ($comentario->getEvento() === $this) {
                $comentario->setEvento(null);
            }
        }

        return $this;
    }
}
