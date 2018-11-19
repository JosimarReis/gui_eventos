<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Doctrine\ORM\EntityRepository;

use App\Entity\Usuario;
use App\Form\UsuarioType;

class UsuarioController extends Controller
{
    /**
     * @Route("/admin/usuarios", name="usuario")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $dql = "SELECT u FROM \App\Entity\Usuario u ORDER BY u.nome";
        $query = $entityManager->createQuery($dql);
        $usuarios = $query->getResult();
        
        return $this->render('usuario/lista.twig',[
            'usuarios' => $usuarios,
        ]);
    }
    
    /**
     * @Route("/admin/usuarios/novo")
     */
    public function nova(Request $request,UserPasswordEncoderInterface $encoder) {


        $usuario = new Usuario();

        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new Usuario();
            $encoded  = $encoder->encodePassword($usuario, $usuario->getPassword()); 

            $usuario->setPassword($encoded);

            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();
            return $this->redirect('/admin/usuarios');
        }

        return $this->render(
                    'usuario/formulario.twig', [
                        'form' => $form->createView(),
                        'titulo' => "Cadastrar",
                        'pass' => true
                        ]
        );
    }
 /**
     * @Route("/admin/usuarios/alterar/{id}")
     */
    public function alterar($id, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository(Usuario::class)
                ->find($id);

        if (!$usuario) {
            return $this->redirect('/admin/usuarios');
        }

        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->remove('password');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();
            return $this->redirect('/admin/usuarios');
        }

        return $this->render(
                        'usuario/alterar.twig', [
                    'form' => $form->createView(),
                    'titulo' => "Alterar",
                    ]
        );
    }

    /**
     * @Route("/admin/usuarios/remover/{id}")
     */
    public function remover($id, Request $request) {

        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository(Usuario::class)
                ->find($id);
        
        $em->remove($usuario);
        $em->flush();
        return $this->redirect('/admin/usuarios');
    }

}
