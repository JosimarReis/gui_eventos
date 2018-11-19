<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EstadoRepository")
 */
class Estado
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $nome;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cidade", mappedBy="estado")
     */
    private $cidades;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $sigla;

    public function __construct()
    {
        $this->cidades = new ArrayCollection();
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

    /**
     * @return Collection|Cidade[]
     */
    public function getCidades(): Collection
    {
        return $this->cidades;
    }

    public function addCidade(Cidade $cidade): self
    {
        if (!$this->cidades->contains($cidade)) {
            $this->cidades[] = $cidade;
            $cidade->setEstado($this);
        }

        return $this;
    }

    public function removeCidade(Cidade $cidade): self
    {
        if ($this->cidades->contains($cidade)) {
            $this->cidades->removeElement($cidade);
            // set the owning side to null (unless already changed)
            if ($cidade->getEstado() === $this) {
                $cidade->setEstado(null);
            }
        }

        return $this;
    }

    public function getSigla(): ?string
    {
        return $this->sigla;
    }

    public function setSigla(string $sigla): self
    {
        $this->sigla = $sigla;

        return $this;
    }
}
