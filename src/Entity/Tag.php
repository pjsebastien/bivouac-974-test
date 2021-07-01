<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=bivouac::class, inversedBy="tags")
     * @ORM\JoinTable(name="tag_bivouac")
     */
    private $bivouac;

    

    public function __construct()
    {
        $this->bivouac = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|bivouac[]
     */
    public function getBivouac(): Collection
    {
        return $this->bivouac;
    }

    public function addBivouac(bivouac $bivouac): self
    {
        if (!$this->bivouac->contains($bivouac)) {
            $this->bivouac[] = $bivouac;
        }

        return $this;
    }

    public function removeBivouac(bivouac $bivouac): self
    {
        $this->bivouac->removeElement($bivouac);

        return $this;
    }

    
    
}
