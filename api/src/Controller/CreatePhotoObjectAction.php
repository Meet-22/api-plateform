<?php

namespace App\Controller;

use App\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

#[AsController]
final class CreatePhotoObjectAction extends AbstractController
{
    protected $projectDir;

    public function __construct(ContainerInterface $container)
    {
        $this->projectDir = $container->getParameter('kernel.project_dir');
    }

    public function __invoke(Request $request, HttpClientInterface $client, EncoderFactoryInterface $encoderFactory)
    {
        $provider = $request->request->get('provider');
        $path = $request->request->get('path');
        $uploadedFile = $request->files->get('file');

        $folderPath = '%kernel.project_dir%/public/media';
        $pathImageName = $this->saveImage($path);

        if($pathImageName == null) {
            return new JsonResponse([
                'error' => 'No Image found'
            ], 401);
        }

        $photo = new Photo();
        $photo->provider = $provider;
        $photo->path = $path;
        if($uploadedFile) {
            $photo->file = $uploadedFile;
        } else {
            $photo->filePath = $pathImageName;
        }

        return $photo;
    }

   
    private function saveImage($imagePath)
    {
        $photoDir = $this->projectDir.Photo::IMAGE_FOLDER;
        $fileName = "";
        if ($imagePath != "") {
           
            $getFileContent = file_get_contents($imagePath);
            dump(basename($imagePath));
            $file_info = new \finfo(FILEINFO_MIME);
            $mime_type = $file_info->buffer($getFileContent);
            $ext = '';
            switch ($mime_type) {
                case "image/jpeg":
                case "image/jpeg; charset=binary":
                    $ext = "jpg";
                    break;
                case "image/png":
                case "image/png; charset=binary":
                    $ext = "png";
                    break;
                case "image/gif":
                case "image/gif; charset=binary":
                    $ext = "gif";
                    break;
                default;
            }
            if ($ext != "") {
                $fileName = md5(rand(0, 10)).".".$ext;
                file_put_contents($photoDir.$fileName, $getFileContent);
            } else {
                return null;
            }

            return $fileName;
        }
        return null;
    }
}
