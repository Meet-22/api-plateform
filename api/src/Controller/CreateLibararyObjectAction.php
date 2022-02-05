<?php

namespace App\Controller;

use App\Entity\Libarary;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use DateTimeImmutable;

#[AsController]
final class CreateLibararyObjectAction extends AbstractController
{
    public function __invoke(Request $request)
    {
        $userRole = $this->getUser()->getRoles();
        $date = new \DateTimeImmutable('@'.strtotime('now'));
        $libarary = new Libarary();
        if (in_array("ROLE_USER", $userRole)) {
            $photoId = $request->request->get('photoId');
            $libararyName = $request->request->get('libararyName');
            $comments = $request->request->get('comments');

            $libarary->userId = $this->getUser()->getId();
            $libarary->photoId = $photoId;
            $libarary->comments = $comments;
            $libarary->createdAt = $date;
        }
        return $libarary;
    }
}
