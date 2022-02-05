<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PhotoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Filter\CustomSearchFilter;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use App\Controller\CreatePhotoObjectAction;

/**
 *  @Vich\Uploadable
 */
#[ORM\Entity(repositoryClass: PhotoRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['photo']],
    itemOperations: ['get', 'delete', 'put'],
    collectionOperations: [
        'get',
        'post' => [
            "security" => "is_granted('ROLE_ADMIN')",
            'controller' => CreatePhotoObjectAction::class,
            'deserialize' => false,
            'openapi_context' => [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'provider' => [
                                        'type' => 'string',
                                        'format' => 'raw',
                                    ],
                                    'path' => [
                                        'type' => 'string',
                                        'format' => 'raw',
                                    ],
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]
)]
#[ApiFilter(CustomSearchFilter::class)]
class Photo
{
    const IMAGE_FOLDER = '/public/media/';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("photo")]
    public $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups("photo")]
    public $provider;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups("photo")]
    public $path;

    /**
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="filePath")
     */
    public $file = null;

    #[ORM\Column(nullable: true)]
    public ?string $filePath = null;

    #[ORM\OneToMany(mappedBy: 'photo', targetEntity: Tags::class)]
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function setProvider(?string $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return Collection|Tags[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->setPhoto($this);
        }

        return $this;
    }

    public function removeTag(Tags $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getPhoto() === $this) {
                $tag->setPhoto(null);
            }
        }

        return $this;
    }

    public function setFilePath($filePath): Photo
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * @return string|null
     */
    public function geFilePath(): ?string
    {
        return $this->filePath;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : self::IMAGE_FOLDER.$this->path;
    }
}
