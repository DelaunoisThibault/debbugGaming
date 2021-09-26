<?php

namespace App\DQL;

use Doctrine\ORM\EntityManagerInterface;

class BugRatingCalculated
{
    public function bugRating(EntityManagerInterface $manager){
        $query = $manager->createQuery('SELECT u, p FROM Game u JOIN u.Bug p');
        $game = $query->getResult();
        $numberOfBugs = $this->count($game);
        $rating = ($numberOfBugs*0.33);

    }


}