<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 * @UniqueEntity(
 * fields={"Username"},
 * message= "Votre nnom d'utilisateur est dejà créé")
 */
class Admin implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage=" votre mot de passe doit faire minimum 8 caractères")
     * 
     */
    private $Password;
    /**
     * @Assert\EqualTo(propertyPath="Password" , message="Vous n'avez pas saisi les mêmes mots de passe!!!")
     */
    public $confirm_Password;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $CreatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    public function setUsername(string $Username): self
    {
        $this->Username = $Username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(?\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function eraseCredentials(){}

    public function getSalt() {}

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

}
