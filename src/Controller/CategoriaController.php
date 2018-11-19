<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityRepository;

use App\Entity\Categoria;
use App\Form\CategoriaType;

class CategoriaController extends Controller
{
    /**
     * @Route("/admin/categorias", name="categoria")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $dql = "SELECT c FROM \App\Entity\Categoria c ORDER BY c.nome";
        $query = $entityManager->createQuery($dql);
        $categorias = $query->getResult();
        
        return $this->render('categoria/lista.twig',[
            'categorias' => $categorias,
        ]);
    }
    
    /**
     * @Route("/admin/categorias/novo")
     */
    public function nova(Request $request) {


        $categoria = new Categoria();

        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new Categoria();
            $em = $this->getDoctrine()->getManager();
            $em->persist($categoria);
            $em->flush();
            return $this->redirect('/admin/categorias');
        }

        return $this->render(
                    'categoria/formulario.twig', [
                        'form' => $form->createView(),
                        'titulo' => "Cadastrar",
                        'pass' => true
                        ]
        );
    }
 /**
     * @Route("/admin/categorias/alterar/{id}")
     */
    public function alterar($id, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $categoria = $em->getRepository(Categoria::class)
                ->find($id);

        if (!$categoria) {
            return $this->redirect('/admin/categorias');
        }

        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categoria);
            $em->flush();
            return $this->redirect('/admin/categorias');
        }

        return $this->render(
                        'categoria/formulario.twig', [
                    'form' => $form->createView(),
                    'titulo' => "Alterar",
                    ]
        );
    }

    /**
     * @Route("/admin/categorias/remover/{id}")
     */
    public function remover($id, Request $request) {

        $em = $this->getDoctrine()->getManager();

        $categoria = $em->getRepository(Categoria::class)
                ->find($id);
        
        $em->remove($categoria);
        $em->flush();
        return $this->redirect('/admin/categorias');
    }

}
