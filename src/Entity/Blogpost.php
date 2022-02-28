<?php

namespace App\Entity;

use App\Repository\BlogpostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlogpostRepository::class)]
class Blogpost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'text')]
    private $contenu;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $creatAt;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image_path;

    #[ORM\Column(type: 'datetime',  nullable: true)]
    private $date;

    #[ORM\ManyToOne(targetEntity: Onglet::class, inversedBy: 'blogposts')]
    #[ORM\JoinColumn(nullable: false)]
    private $onglet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getCreatAt(): ?\DateTimeImmutable
    {
        return $this->creatAt;
    }

    public function setCreatAt(\DateTimeImmutable $creatAt): self
    {
        $this->creatAt = $creatAt;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->image_path;
    }

    public function setImagePath(?string $image_path): self
    {
        $this->image_path = $image_path;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getOnglet(): ?Onglet
    {
        return $this->onglet;
    }

    public function setOnglet(?Onglet $onglet): self
    {
        $this->onglet = $onglet;

        return $this;
    }
}
