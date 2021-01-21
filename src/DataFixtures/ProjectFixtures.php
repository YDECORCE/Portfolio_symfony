<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Project;

class ProjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=1; $i<=10; $i++){
            $project= new Project();
            $project->setTitle("Projet n°$i")
                    ->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus pharetra quam nec tortor laoreet, in mattis leo pellentesque. Proin tempor eros a quam malesuada tempus ac in diam. Phasellus ut sollicitudin lacus. Sed pretium libero risus, et lobortis dolor pulvinar eu. Mauris sed ipsum blandit, vehicula libero eget, lobortis diam. Ut vel dignissim quam, eget tincidunt tortor. Quisque eget varius risus. Donec finibus porta feugiat. Vestibulum elementum suscipit sapien et tempor. Aliquam hendrerit nunc quis sem mattis, sed aliquet dolor hendrerit. Etiam laoreet finibus eros in consequat. Sed vitae consequat nisi. Duis suscipit turpis quis nisl vestibulum porttitor. Donec suscipit.")
                    ->setImage("https://placehold.it/250x150")
                    ->setGithub("https://github.com/YDECORCE")
                    ->setWeblink("https://yannd.promo-44.codeur.online");
            $manager->persist($project);

        }

        $manager->flush();
    }
}
