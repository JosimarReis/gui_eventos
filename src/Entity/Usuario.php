<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
 */
class Usuario implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $roles;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evento", mappedBy="usuario")
     */
    private $eventos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comentario", mappedBy="usuario")
     */
    private $comentarios;

    public function __construct()
    {
        $this->eventos = new ArrayCollection();
        $this->comentarios = new ArrayCollection();
    }
    public function getId() : ? int
    {
        return $this->id;
    }
    public function getNome() : ? string
    {
        return $this->nome;
    }

    public function setNome(string $nome) : self
    {
        $this->nome = $nome;

        return $this;
    }
    public function getEmail() : ? string
    {
        return $this->email;
    }

    public function setEmail(string $email) : self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Evento[]
     */
    public function getEventos() : Collection
    {
        return $this->eventos;
    }

    public function addEvento(Evento $evento) : self
    {
        if (!$this->eventos->contains($evento)) {
            $this->eventos[] = $evento;
            $evento->setUsuario($this);
        }

        return $this;
    }

    public function removeEvento(Evento $evento) : self
    {
        if ($this->eventos->contains($evento)) {
            $this->eventos->removeElement($evento);
            // set the owning side to null (unless already changed)
            if ($evento->getUsuario() === $this) {
                $evento->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comentario[]
     */
    public function getComentarios() : Collection
    {
        return $this->comentarios;
    }

    public function addComentario(Comentario $comentario) : self
    {
        if (!$this->comentarios->contains($comentario)) {
            $this->comentarios[] = $comentario;
            $comentario->setUsuario($this);
        }

        return $this;
    }

    public function removeComentario(Comentario $comentario) : self
    {
        if ($this->comentarios->contains($comentario)) {
            $this->comentarios->removeElement($comentario);
            // set the owning side to null (unless already changed)
            if ($comentario->getUsuario() === $this) {
                $comentario->setUsuario(null);
            }
        }

        return $this;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername() : string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles()
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
       // $roles = 'ROLE_USER';

        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword() : string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password) : self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    function __toString()
    {
        return $this->getNome();
    }
}
