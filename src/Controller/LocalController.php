<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityRepository;

use App\Entity\Local;
use App\Form\LocalType;

class LocalController extends Controller
{
    /**
     * @Route("/admin/locais", name="local")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $dql = "SELECT l FROM \App\Entity\Local l ORDER BY l.logradouro";
        $query = $entityManager->createQuery($dql);
        $locais = $query->getResult();
        
        return $this->render('local/lista.twig',[
            'locais' => $locais,
        ]);
    }
    
    /**
     * @Route("/admin/locais/novo")
     */
    public function nova(Request $request) {


        $local = new Local();

        $form = $this->createForm(LocalType::class, $local);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new Local();
            $em = $this->getDoctrine()->getManager();
            $em->persist($local);
            $em->flush();
            return $this->redirect('/admin/locais');
        }

        return $this->render(
                    'local/formulario.twig', [
                        'form' => $form->createView(),
                        'titulo' => "Cadastrar",
                        'pass' => true
                        ]
        );
    }
 /**
     * @Route("/admin/locais/alterar/{id}")
     */
    public function alterar($id, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $local = $em->getRepository(Local::class)
                ->find($id);

        if (!$local) {
            return $this->redirect('/admin/locais');
        }

        $form = $this->createForm(LocalType::class, $local);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($local);
            $em->flush();
            return $this->redirect('/admin/locais');
        }

        return $this->render(
                        'local/formulario.twig', [
                    'form' => $form->createView(),
                    'titulo' => "Alterar",
                    ]
        );
    }

    /**
     * @Route("/admin/locais/remover/{id}")
     */
    public function remover($id, Request $request) {

        $em = $this->getDoctrine()->getManager();

        $local = $em->getRepository(Local::class)
                ->find($id);
        
        $em->remove($local);
        $em->flush();
        return $this->redirect('/admin/locais');
    }

}
