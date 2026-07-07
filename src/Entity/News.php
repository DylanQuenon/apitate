<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Entity\MediaObject;
use App\Repository\NewsRepository;
use Cocur\Slugify\Slugify;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NewsRepository::class)]
#[ApiResource(
    normalizationContext:[
        'groups' => ['news_read']
    ],
    operations:[
        new Get(),
        new Post(),
        new Delete(),
        new Patch(),
        new Put(),
        new GetCollection(),
        new Get(
            uriTemplate: '/news/s/{slug}',
            uriVariables: [
                'slug' => new Link(fromClass: News::class, identifiers: ['slug'])
            ]
        )
    ],
)]
#[ApiFilter(SearchFilter::class, properties: [
    'title' => 'partial'
])]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields:["title"], message:"This title already exists.")]
class News
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The title is required.")]
    #[Assert\Length(
        min: 2,
        minMessage: "The title must be at least {{ limit }} characters long.",
        max: 255,
        maxMessage: "The title cannot be longer than {{ limit }} characters."
    )]
    #[Groups(['news_read'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The subtitle is required.")]
    #[Assert\Length(
        min: 2,
        minMessage: "The subtitle must be at least {{ limit }} characters long.",
        max: 255,
        maxMessage: "The subtitle cannot be longer than {{ limit }} characters."
    )]
    #[Groups(['news_read'])]
    private ?string $subtitle = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "The content is required.")]
    #[Assert\Length(
        min: 50,
        minMessage: "The content must be at least {{ limit }} characters long.",
    )]
    #[Groups(['news_read'])]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['news_read'])]
    private $publishedAt = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['news_read'])]
    private ?MediaObject $cover = null;

    #[ORM\Column(length: 255)]
    #[Groups(['news_read'])]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): static
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }


    public function getPublishedAt():  ? \DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt( $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

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
     * Initialize the article slug
     *
     * @return void
     */
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initializeSlug(): void
    {

            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->title);
        
    }

    /**
     * Initialize the date of the publication
     *
     * @return void
     */
    #[ORM\PrePersist]
    public function prePersist(): void
    {
        if(empty($this->publishedAt))
        {
            $this->publishedAt = new \DateTime();
        }
    }
}
