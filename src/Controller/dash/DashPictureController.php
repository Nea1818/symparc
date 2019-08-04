<?php

namespace App\Controller\dash;

use App\Entity\Picture;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/dash/picture")
 */
class DashPictureController extends AbstractController
{
    /**
    * @Route("/{id}", name="dash.picture.delete", methods="DELETE")
    *
    */
    public function delete(Picture $picture, Request $request, ObjectManager $manager)
    {
        $parcId = $picture->getParc()->getId();
        $manager->remove($picture);
        $manager->flush();
    
        $this->addFlash("success", "Votre annonce a bien été supprimée.");
       
        return $this->redirectToRoute('dash.parcs.edit', ['id' => $parcId]);
    }
}
