<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="User")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="L'émail que vous avez tapé est déjà utilisé !"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
     * @UniqueEntity(
     * fields={"email"},
     * message="L'émail que vous avez tapé est déjà utilisé !"
     * )
     */

    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     * min = 5,
     * max = 50,
     * minMessage = "Le nom d'un utilisateur doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Le nom d'un utilisateur doit comporter au plus {{ limit }} caractères"
     * )
     */
    private $username;


    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\Length(
     *      min = 8,
     *      minMessage = "Votre mot de passe doit comporter au minimum {{ limit }} caractères")
     */
    private $password;


    /**
     *  @Assert\EqualTo(propertyPath = "password", message="Vous n'avez pas passé le même mot de passe !" )
     */
    private $confirm_password;

    public function getConfirmPassword()
    {
        return $this->confirm_password;
    }

    public function setConfirmPassword($confirm_password)
    {
        $this->confirm_password = $confirm_password;

        return $this;
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials() {}

    public function getSalt() {}


}