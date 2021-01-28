<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=10, max=255)
     * 
     */
    private $Title;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=10)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Image;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url(
     *          dnsMessage = "The host '{{ value }}' could not be resolved."
     * )
     */
    private $Github;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url(
     *          dnsMessage = "The host '{{ value }}' could not be resolved."
     * )
     */
    private $Weblink;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="projects")
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }

    public function getGithub(): ?string
    {
        return $this->Github;
    }

    public function setGithub(string $Github): self
    {
        $this->Github = $Github;

        return $this;
    }

    public function getWeblink(): ?string
    {
        return $this->Weblink;
    }

    public function setWeblink(string $Weblink): self
    {
        $this->Weblink = $Weblink;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
           
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }
}
