<?php 
namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch {

    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     * @Assert\Range(min=10, max=400, notInRangeMessage="Cette valeur doit être superieur ou égale à 10")
     */
    private $minSurface;

    public function getMaxPrice(): ?int
    {
      return $this->maxPrice;
    }

    public function setMaxPrice(int $maxPrice): self
    {

        $this->maxPrice=$maxPrice;
        return $this;
     }


     public function getMinSurface(): ?int{
        return $this->minSurface;
      }
  
     public function setMinSurface(int $minSurface): self
     {
          $this->minSurfacee=$minSurface;
          return $this;
     }

}