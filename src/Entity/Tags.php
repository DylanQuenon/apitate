<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\TagsRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TagsRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    normalizationContext:[
        'groups' => ['tags_read']
    ],
    operations:[
        new Get(),
        new Post(),
        new Delete(),
        new Patch(),
        new Put(),
        new GetCollection()
    ]
)]
class Tags
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['tags_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['tags_read', 'gallery_read'])]
    #[Assert\NotBlank(message: "The tag name is required.")]
    #[Assert\Length(
            min: 2,
            max: 50,
            minMessage: "The name must be at least {{ limit }} characters long.",
            maxMessage: "The name cannot be longer than {{ limit }} characters."
    )]
    private ?string $name = null;
    
    
    #[ORM\Column(length: 255)]
    #[Groups(['tags_read', 'gallery_read'])]
    private ?string $slug=null;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }


    /**
     * Initialize the tags slug
     *
     * @return void
     */
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initializeSlug(): void
    {
        if(empty($this->slug))
        {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->name);
        }
    }
}
