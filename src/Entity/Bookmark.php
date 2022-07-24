<?php

namespace App\Entity;

use App\Repository\BookmarkRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookmarkRepository::class)]

/**
 * @UniqueEntity("URL")
 */
class Bookmark
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $URL;

    #[ORM\Column(type: 'string', length: 255)]
    private $provider;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    private $author;

    #[ORM\Column(type: 'datetime_immutable')]
    /**
     * @Gedmo\Timestampable(on="create")
     */
    private $created_at;

    #[ORM\Column(type: 'datetime_immutable')]
     /**
     * @Gedmo\Timestampable(on="update")
     */
    private $updated_at;

    #[ORM\Column(type: 'datetime_immutable')]
    private $pub_at;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'integer')]
    private $width;

    #[ORM\Column(type: 'integer')]
    private $height;

    #[ORM\Column(type: 'integer')]
    private $duration = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getURL(): ?string
    {
        return $this->URL;
    }

    public function setURL(string $URL): self
    {
        $this->URL = $URL;

        return $this;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function setProvider(string $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }


    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }


    public function getPubAt(): ?\DateTimeImmutable
    {
        return $this->pub_at;
    }

    public function setPubAt(\DateTimeImmutable $pub_at): self
    {
        $this->pub_at = $pub_at;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
}
