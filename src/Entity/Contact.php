<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class Contact
{
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=1,max=100)
     */
    private $firstname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=1, max=100)
     */
    private $lastname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/[0-9]{10}/", message="Vous devez saisir au maximum 10 chiffres")
     */
    private $tel;


    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email(message="Cette valeur n'est pas une email valide")
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=10, minMessage="Vous devez saisir au minimum 10 caractères")
     */
    private $mesage;

    /**
     * @var Property|null
     */
    private $property;


    public function __construct()
    {
    }

    public function getFirstName(): ?string
    {
        return $this->firstname;
    }

    public function setFirstName(?string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastname;
    }


    public function setLastName(?string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }


    public function setTel(?string $tel): self
    {
        $this->tel = $tel;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }


    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getMesage(): ?string
    {
        return $this->mesage;
    }


    public function setMesage(?string $mesage): self
    {
        $this->mesage = $mesage;
        return $this;
    }

    

    /**
     * @param Property|null
     */
    public function setProperty(?Property $property): self
    {
        $this->property = $property;
        return $this;
    }

    /**
     * Get the value of property
     *
     * @return  Property|null
     */ 
    public function getProperty()
    {
        return $this->property;
    }
}
