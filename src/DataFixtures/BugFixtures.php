<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Bug;
use App\Entity\Game;
use App\Entity\Editor;



class BugFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for($i=1; $i<=10; $i++){
            $editor = new Editor();
            $editor->setEditorName("editor n°".$i);

            $user = new User();
            $user->setEmail('test'.$i.'@gmail.com');
            $user->setPseudonym('MachinTruc'.$i);
            $user->setAvatar("assets\images\user_icon.png");
            $user->setPassword("123");
            $user->setLocked(false);
            $user->setIsVerified(true);

            $game = new Game();
            $game->setNameGame("jeux n°".$i);
            $game->setYearOfPublication(rand(1990,2020));
            $game->setBugRating(rand(0,5));
            $game->setIdEditor($editor);

            $bug = new Bug();
            $bug->setIdGame($game);
            $bug->setTitleBug("Titre de bug n°".$i);
            $bug->setSubtitleBug("Sous-titre du bug n°".$i);
            $bug->setSmallTextBug("Un petit texte pour le bug n°".$i);
            $bug->setDescriptionImgBug("02-SNAKE.jpg");
            $bug->setDescriptionTextBug("Pourriez-vous en dire autant de vous, continua-t-elle en riant, revenez à vous. 
            Engourdi d'immobilité, l'examen continua. Questions qui divisaient la foule et le désordre au milieu de la tente de cérémonie dont il forme l'axe.");
            $bug->setFrequencyBug("Rare");
            $bug->setSeverityBug("Faible");
            $bug->setIdUser($user);
            $bug->setPublished(true);

            $manager->persist($editor);
            $manager->persist($game);
            $manager->persist($user);
            $manager->persist($bug);
        }

        $manager->flush();
    }


}
