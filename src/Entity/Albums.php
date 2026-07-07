<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\AlbumsRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AlbumsRepository::class)]
#[ApiResource(
      normalizationContext:[
        'groups' => ['albums_read']
    ],

    operations:[
        new Get(),
        new Post(),
        new Delete(),
        new Patch(),
        new Put(),
        new GetCollection()
    ],
     order: ['releasedAt' => 'DESC'] //default sorting

)]
class Albums
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['albums_read'])]
    #[Assert\NotBlank(message: "The name is required.")]
    #[Assert\Length(
            min: 2,
            minMessage: "The name must be at least {{ limit }} characters long."
    )]
    private ?string $name = null;

   
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message: "The release date is required.")]
    #[Assert\Type(type: "datetime", message: "The release date must be in the format YYYY-MM-DD")]
    #[Groups(['albums_read'])]
    private $releasedAt = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['albums_read'])]
    #[Assert\NotBlank(message: "The description is required")]
    #[Assert\Length(
        min: 2,
        minMessage: "The name must be at least {{ limit }} characters long."
    )]
    private ?string $description = null;

 
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The streaming URL is required")]
    #[Assert\Url(message: "The streaming URL must be a valid URL")]
    #[Groups(['albums_read'])]
    private ?string $streamUrl = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['albums_read'])]
    private ?MediaObject $cover = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getReleasedAt(): ?DateTimeInterface
    {
        return $this->releasedAt;
    }

    public function setReleasedAt($releasedAt): self
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }


    public function getStreamUrl(): ?string
    {
        return $this->streamUrl;
    }

    public function setStreamUrl(string $streamUrl): static
    {
        $this->streamUrl = $streamUrl;

        return $this;
    }

    public function getCover(): ?MediaObject
    {
        return $this->cover;
    }

    public function setCover(MediaObject $cover): static
    {
        $this->cover = $cover;

        return $this;
    }
}
