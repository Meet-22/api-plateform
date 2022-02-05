<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LibararyRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\CreateLibararyObjectAction;


#[ORM\Entity(repositoryClass: LibararyRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => [
            "security" => "is_granted('ROLE_USER')",
            'controller' => CreateLibararyObjectAction::class,
            'deserialize' => false,
            'openapi_context' => [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'photoId' => [
                                        'type' => 'integer',
                                        'format' => 'raw'
                                    ],
                                    'comments' => [
                                        'type' => 'string',
                                        'format' => 'raw' 
                                    ]
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]
)]
class Libarary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    public $userId;

    #[ORM\Column(type: 'integer')]
    public $photoId;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    public $createdAt;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public $comments;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getPhotoId(): ?int
    {
        return $this->photoId;
    }

    public function setPhotoId(int $photoId): self
    {
        $this->photoId = $photoId;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }
}
