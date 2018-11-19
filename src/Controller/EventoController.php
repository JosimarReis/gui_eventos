<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityRepository;

use App\Entity\Usuario;
use App\Entity\Evento;
use App\Form\EventoType;

class EventoController extends Controller
{
    /**
     * @Route("/admin/eventos", name="evento")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $dql = "SELECT e FROM \App\Entity\Evento e ORDER BY e.data DESC";
        $query = $entityManager->createQuery($dql);
        $eventos = $query->getResult();

        return $this->render('evento/lista.twig', [
            'eventos' => $eventos,
        ]);
    }

    /**
     * @Route("/admin/eventos/novo")
     */
    public function nova(Request $request)
    {


        $evento = new Evento();

        $form = $this->createForm(EventoType::class, $evento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $existe = $this->getDoctrine()
                ->getRepository(Evento::class)
                ->existeEvento($evento);
            if (!$existe) {

                $usuario = $this->get('security.token_storage')->getToken()->getUser();
                $usuario = $em->getRepository(Usuario::class)
                    ->find($usuario->getId());

                $evento->setUsuario($usuario);
                $evento->setVisitas(0);

                $em->persist($evento);
                $em->flush();
                return $this->redirect('/admin/eventos');

            } else {
                $this->addFlash(
                    'notice',
                    'O local, data e hora do evento já esta sendo utilizado!'
                );
            }
        }

        return $this->render(
            'evento/formulario.twig',
            [
                'form' => $form->createView(),
                'titulo' => "Cadastrar",
                'pass' => true
            ]
        );
    }
    /**
     * @Route("/admin/eventos/alterar/{id}")
     */
    public function alterar($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $evento = $em->getRepository(Evento::class)
            ->find($id);

        if (!$evento) {
            return $this->redirect('/admin/eventos');
        }


        $form = $this->createForm(EventoType::class, $evento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $existe = $this->getDoctrine()
                ->getRepository(Evento::class)
                ->existeEvento($evento);
            if (!$existe) {


                $em->persist($evento);
                $em->flush();
                return $this->redirect('/admin/eventos');
            } else {
                $this->addFlash(
                    'notice',
                    'O local, data e hora do evento já esta sendo utilizado!'
                );
            }

        }

        return $this->render(
            'evento/formulario.twig',
            [
                'form' => $form->createView(),
                'titulo' => "Alterar",
            ]
        );
    }


    /**
     * @Route("/admin/eventos/remover/{id}")
     */
    public function remover($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $evento = $em->getRepository(Evento::class)
            ->find($id);

        $em->remove($evento);
        $em->flush();
        return $this->redirect('/admin/eventos');
    }

}
