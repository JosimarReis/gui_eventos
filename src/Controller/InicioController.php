<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Evento;

class InicioController extends AbstractController
{
    /**
     * @Route("/", name="inicio")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $dql = "SELECT e FROM \App\Entity\Evento e ORDER BY e.data DESC";
        $query = $entityManager->createQuery($dql);
        $eventos = $query->getResult();

        return $this->render('inicio/index.html.twig', [
            'eventos' => $eventos,
        ]);
    }

        /**
     * @Route("/ver/{evento_id}", name="ver_evento")
     */
    public function ver($evento_id)
    {
        $em = $this->getDoctrine()->getManager();

        $evento = $em->getRepository(Evento::class)
            ->find($evento_id);

        if (!$evento) {
            return $this->redirect('/');
        }   
        $visita = $evento->getVisitas() +1;

        $evento->setVisitas($visita);
        $em->persist($evento);
        $em->flush();

        return $this->render('inicio/ver.twig', [
            'evento' => $evento,
        ]);
    }
}
