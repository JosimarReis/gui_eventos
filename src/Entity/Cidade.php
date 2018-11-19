<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CidadeRepository")
 */
class Cidade
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Estado", inversedBy="cidades")
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Local", mappedBy="cidade")
     */
    private $locais;

    public function __construct()
    {
        $this->locais = new ArrayCollection();
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

    public function getEstado(): ?Estado
    {
        return $this->estado;
    }

    public function setEstado(?Estado $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * @return Collection|Local[]
     */
    public function getLocais(): Collection
    {
        return $this->locais;
    }

    public function addLocal(Local $local): self
    {
        if (!$this->locais->contains($local)) {
            $this->locais[] = $local;
            $local->setCidade($this);
        }

        return $this;
    }

    public function removeLocal(Local $local): self
    {
        if ($this->locais->contains($local)) {
            $this->locais->removeElement($local);
            // set the owning side to null (unless already changed)
            if ($local->getCidade() === $this) {
                $local->setCidade(null);
            }
        }

        return $this;
    }
}
