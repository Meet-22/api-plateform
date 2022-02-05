<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Photo;
use App\Entity\Tags;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $photo = new Photo();
        $photo->setProvider('StockPic');
        $photo->setPath('home');
        $photo->setFilePath('shutter.jpeg');
        $manager->persist($photo);
        $this->addReference('shutterstock', $photo);

        $photo1 = new Photo();
        $photo1->setProvider('Fotolia');
        $photo1->setPath('home');
        $photo1->setFilePath('fotolia.jpeg');
        $manager->persist($photo1);
        $this->addReference('fotolia', $photo1);

        $photo2 = new Photo();
        $photo2->setProvider('Stocksy');
        $photo2->setPath('downloads');
        $photo2->setFilePath('stocksy.jpeg');
        $manager->persist($photo2);
        $this->addReference('stocksy', $photo2);

        $photo3 = new Photo();
        $photo3->setProvider('Getty Images');
        $photo3->setPath('downloads');
        $photo3->setFilePath('stocksy.jpeg');
        $manager->persist($photo3);
        $this->addReference('gettyImages', $photo3);

        $photo4 = new Photo();
        $photo4->setProvider('iStock');
        $photo4->setPath('pictures');
        $photo4->setFilePath('getty.jpeg');
        $manager->persist($photo4);
        $this->addReference('istock', $photo4);

        $photo5 = new Photo();
        $photo5->setProvider('StockPic');
        $photo5->setPath('https://stokpic.com/wp-content/uploads/2018/03/Bride-and-grooms-shoes-1-400x250.jpg');
        $photo5->setFilePath('Bride-and-grooms.jpg');
        $manager->persist($photo5);
        $this->addReference('stockPic', $photo5);
        
        $manager->flush();

        $tags = new Tags();
        $tags->setTagsName("shutterImage Tags1");
        $ph1 = $manager->merge($this->getReference('shutterstock'));
        $tags->setPhoto($ph1);
        $manager->persist($tags);

        $tags1 = new Tags();
        $tags1->setTagsName("shutterImage Tags2");
        $ph1 = $manager->merge($this->getReference('shutterstock'));
        $tags1->setPhoto($ph1);
        $manager->persist($tags1);

        $tags2 = new Tags();
        $tags2->setTagsName("Istock Image Tags1");
        $ph2 = $manager->merge($this->getReference('istock'));
        $tags2->setPhoto($ph2);
        $manager->persist($tags2);

        $tags3 = new Tags();
        $tags3->setTagsName("FotoliaImage Tags1");
        $ph3 = $manager->merge($this->getReference('fotolia'));
        $tags3->setPhoto($ph3);
        $manager->persist($tags3);

        $tags4 = new Tags();
        $tags4->setTagsName("Stockpic Image Tag");
        $ph4 = $manager->merge($this->getReference('stockPic'));
        $tags4->setPhoto($ph4);
        $manager->persist($tags4);

        $manager->flush();

        $user = new User();
        $user->setEmail('admin@admin.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword('$2y$13$R3SUvvIZX9U3pt9f/AyEc.dK5IWDXLaKdFiNPztAjOqfQZZH4M/BG');//Hashed password ("12345678")
        $manager->persist($user);

        $user1 = new User();
        $user1->setEmail('user@yopmail.com');
        $user1->setRoles(['ROLE_USER']);
        $user1->setPassword('$2y$13$RWGTaQXDhpk29crxdhl5SORYJHhEmOrJtsBaE/G9KnNVYzs82Sz8i');//Hashed password ("12345678")
        $manager->persist($user1);

        $manager->flush();
    }

}
