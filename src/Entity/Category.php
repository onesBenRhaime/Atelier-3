<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'CategoryId', targetEntity: Product::class)]
    private Collection $ProductId;

    public function __construct()
    {
        $this->ProductId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductId(): Collection
    {
        return $this->ProductId;
    }

    public function addProductId(Product $productId): self
    {
        if (!$this->ProductId->contains($productId)) {
            $this->ProductId->add($productId);
            $productId->setCategoryId($this);
        }

        return $this;
    }

    public function removeProductId(Product $productId): self
    {
        if ($this->ProductId->removeElement($productId)) {
            // set the owning side to null (unless already changed)
            if ($productId->getCategoryId() === $this) {
                $productId->setCategoryId(null);
            }
        }

        return $this;
    }
}
