<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class LuckyController
{
    public function number(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body><h1>Voici ma première page Symfony</h1><p>Lucky number: '.$number.'</p></body></html>'
        );
    }
}