<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Entity\MediaObject;
use App\Entity\Tags;
use App\Repository\GalleryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GalleryRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    normalizationContext:[
        'groups' => ['gallery_read']
    ],
    operations:[
        new Get(),
        new Post(),
        new Delete(),
        new Patch(),
        new Put(),
        new GetCollection()
    ],


)]
#[ApiFilter(SearchFilter::class, properties: [
    'tag.slug' => 'exact'
])]
#[ApiFilter(OrderFilter::class, properties: [
    'publishedAt'
])]

class Gallery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['gallery_read'])]
    private ?string $name = null;

    /**
     * @var Collection<int, Tags>
     */
    #[ORM\ManyToMany(targetEntity: Tags::class)]
     #[Groups(['gallery_read'])]
    private Collection $tag;

    #[ORM\ManyToOne(targetEntity: MediaObject::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[ApiProperty(types: ['https://schema.org/image'])]
    #[Groups(['gallery_read'])]
    public ?MediaObject $image = null;
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['gallery_read'])]
    private $publishedAt = null;

    public function __construct()
    {
        $this->tag = new ArrayCollection();
    }

    #[ORM\PrePersist]
    /**
     * Automatically set the publication date on the current date
     *
     * @return void
     */
    public function prePersist(): void
    {
        if(empty($this->publishedAt))
        {
            $this->publishedAt = new \DateTime();
        }
    }

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

    /**
     * @return Collection<int, Tags>
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tags $tag): static
    {
        if (!$this->tag->contains($tag)) {
            $this->tag->add($tag);
        }

        return $this;
    }

    public function removeTag(Tags $tag): static
    {
        $this->tag->removeElement($tag);

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt($publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }
}
