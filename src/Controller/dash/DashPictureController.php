<?php

namespace App\Controller\dash;

use App\Entity\Picture;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $picture->getId(), $data['_token'])) {
            $manager->remove($picture);
            $manager->flush();
            return new JsonResponse(['success' => 1]);
        }
       
        return new JsonResponse(['error' => 'Token invalid'], 400);
    }
}
