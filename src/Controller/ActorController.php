<?php


namespace App\Controller;

use App\Entity\Actor;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/actor", name="actor_")
 * Class ActorController
 * @package App\Controller
 */
class ActorController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{

    /**
     * @Route("/{id}", name="show")
     * @param Actor $actor
     * @return Response
     */
    public function show(Actor $actor)
    {
        return $this->render("actor/show.html.twig", ["actor"=>$actor]);
    }

}