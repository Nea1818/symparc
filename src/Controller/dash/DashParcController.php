<?php

namespace App\Controller\dash;

use App\Entity\Parc;
use App\Form\ParcType;
use App\Repository\ParcRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashParcController extends AbstractController
{
    
    /**
     * @Route("/dash", name="dash.parcs.index")
     * @return Response
     */
    public function index(ParcRepository $repository, ObjectManager $manager)
    {
        $parcs = $repository->findAll();

        return $this->render('dash/parc/index.html.twig', [
            'parcs' => $parcs
        ]);
    }

    /**
         * @Route("/dash/parcs/new", name="dash.parcs.create", requirements={"slug": "[a-z0-9\-]*"})
         *
         * @return Response
         */
    public function create(Request $request, ObjectManager $manager)
    {
        $parc = new Parc();
    
        $form = $this->createForm(ParcType::class, $parc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($parc);
            $manager->flush();
   
            $this->addFlash(
                'success',
                "Votre annonce a bien été enregistrée."
                );
            return $this->redirectToRoute('dash.parcs.show', [
                    'id' => $parc->getId()
                ]);
        }
    
        return $this->render('dash/parc/new.html.twig', [
                'parc' => $parc,
                'form' => $form->createView()
            ]);
    }

    /**
    *
    * Afficher une seule annonce
    *
    * @Route("/dash/parcs/{id}", name="dash.parcs.show", requirements={"slug": "[a-z0-9\-]*"})
    *
    * @return Response
    */
    public function show(Parc $parc)
    {
        return $this->render('dash/parc/show.html.twig', [
            'parc' => $parc,
        ]);
    }
    
    /**
     * @Route("/dash/{id}/", name="dash.parcs.edit", requirements={"slug": "[a-z0-9\-]*"}, methods="GET|POST"))
     *
     * @return Response
     */
    public function edit(Parc $parc, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(ParcType::class, $parc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($parc);
            $manager->flush();

                
            $this->addFlash(
                'success',
                "Votre annonce a bien été modifiée."
                );
            return $this->redirectToRoute('dash.parcs.show', [
                    'id' => $parc->getId()
                ]);
        }
    
        return $this->render('dash/parc/edit.html.twig', [
                'parc' => $parc,
                'form' => $form->createView()
            ]);
    }
    
    /**
     * @Route("/dash/parcs/{id}/delete", name="dash.parcs.delete", methods="DELETE")
     *
     * @return Response
     */
    public function delete(Parc $parc, ObjectManager $manager)
    {
        $manager->remove($parc);
        $manager->flush();
    
        $this->addFlash("success", "Votre annonce a bien été supprimée.");
        return $this->redirectToRoute('dash.parcs.index');
    }
}
