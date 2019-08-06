<?php

namespace App\Controller;

use App\Entity\Parc;
use App\Entity\ParcSearch;
use App\Form\ParcSearchType;
use App\Repository\ParcRepository;
use Knp\Component\Pager\PaginatorInterface;
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
    public function index(Request $request, ObjectManager $manager, ParcRepository $repository, PaginatorInterface $paginator)
    {
        $search = new ParcSearch();
        $form = $this->createForm(ParcSearchType::class, $search);
        $form->handleRequest($request);

        
        $parcs = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            4
        );
        $manager->flush();
        return $this->render('parc/index.html.twig', [
            'parcs' => $parcs,
            'form' => $form->createView()
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
