<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;

use App\Entity\Evento;
use App\Entity\Comentario;
use App\Entity\Usuario;
use App\Form\ComentarioType;

class InicioController extends Controller
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
    public function ver($evento_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $evento = $em->getRepository(Evento::class)
            ->find($evento_id);

        if (!$evento) {
            return $this->redirect('/');
        }

        $dql = "SELECT e FROM \App\Entity\Evento e ORDER BY e.id DESC";
        $query = $em->createQuery($dql);
        $query->setMaxResults(5);
        $ultimos = $query->getResult();

        $visita = $evento->getVisitas() + 1;

        $evento->setVisitas($visita);
        $em->persist($evento);
        $em->flush();



        $comentario = new Comentario();

        $form = $this->createForm(ComentarioType::class, $comentario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usuario = $this->get('security.token_storage')->getToken()->getUser();
            $usuario = $em->getRepository(Usuario::class)
                ->find($usuario->getId());
            if ($usuario) {
                $evento->setUsuario($usuario);
                $comentario->setEvento($evento);
                $comentario->setUsuario($usuario);

                $em->persist($comentario);
                $em->flush();
                return $this->redirect("/ver/{$evento_id}");

            }
        }

        return $this->render('inicio/ver.twig', [
            'evento' => $evento,
            'ultimos' => $ultimos,
            'form' => $form->createView()
        ]);
    }
}
