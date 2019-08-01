<?php

namespace App\Controller;

use App\Entity\Parc;
use App\Repository\ParcRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ParcController extends AbstractController
{

    /**
     * @var ParcRepository
     */
    private $repository;

    public function __construct(ParcRepository $repository, ObjectManager $manager)
    {
        $this->repository = $repository;
    }
  
    /**
     * @Route("/parcs", name="parcs.index")
     * @return Response
     */
    public function index(Request $request, ObjectManager $manager, ParcRepository $repository)
    {
        $parcs = $repository->findAll();
        return $this->render('parc/index.html.twig', [
            'parcs' => $parcs,
        ]);
    }

    
    /**
    *
    * Afficher une seule annonce
    *
    * @Route("/parcs/{slug}", name="parcs.show", requirements={"slug": "[a-z0-9\-]*"})
    *
    * @return Response
    */
    public function show(Parc $parc)
    {
        return $this->render('parc/show.html.twig', [
            'parc' => $parc
        ]);
    }
}
