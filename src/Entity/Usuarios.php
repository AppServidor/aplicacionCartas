<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuariosRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Usuarios implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Cartas")
     */
    private $cartas;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ciudad")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $ciudad;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $foto;

    public function __construct()
    {
        $this->cartas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
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

    /**
     * @return Collection|Cartas[]
     */
    public function getCartas(): Collection
    {
        return $this->cartas;
    }

    public function addCarta(Cartas $carta): self
    {
        if (!$this->cartas->contains($carta)) {
            $this->cartas[] = $carta;
        }

        return $this;
    }

    public function removeCarta(Cartas $carta): self
    {
        if ($this->cartas->contains($carta)) {
            $this->cartas->removeElement($carta);
        }

        return $this;
    }

    public function getCiudad(): ?Ciudad
    {
        return $this->ciudad;
    }

    public function setCiudad(?Ciudad $ciudad): self
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }
}
