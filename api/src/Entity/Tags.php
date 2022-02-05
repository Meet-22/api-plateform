<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TagsRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Filter\TagsSearchFilter;

#[ORM\Entity(repositoryClass: TagsRepository::class)]
#[ApiResource]
#[ApiFilter(TagsSearchFilter::class)]
class Tags
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("photo")]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups("photo")]
    private $tagsName;

    #[ORM\ManyToOne(targetEntity: Photo::class, inversedBy: 'tags')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("photo")]
    private $photo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTagsName(): ?string
    {
        return $this->tagsName;
    }

    public function setTagsName(?string $tagsName): self
    {
        $this->tagsName = $tagsName;

        return $this;
    }

    public function getPhoto(): ?Photo
    {
        return $this->photo;
    }

    public function setPhoto(?Photo $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}
