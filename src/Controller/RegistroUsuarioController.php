<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Usuario;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistroUsuarioController extends AbstractController
{
    /**
     * @Route("/registro", name="registro_usuario")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $usuario = new Usuario();
        //cria o formulario de registro
        $form = $this->createFormBuilder($usuario)
            ->add('nome', TextType::class)
            ->add('email', TextType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Senha'),
                'second_options' => array('label' => 'Repita a senha'),
            ])
            ->add('salvar', SubmitType::class, ['label' => 'Cadastrar'])
            ->getForm();
    
        //recebe os dados do formulário 
        $form->handleRequest($request);

        //se o formulario estiver validado e tiver sido enviado, entao salva o registro
        if ($form->isSubmitted() && $form->isValid()) {
            
            //criptografa a senha
            $encoded = $encoder->encodePassword($usuario, $usuario->getPassword());
            $usuario->setPassword($encoded);
            $usuario->setRoles(['ROLE_USER']);
            //chama conexao com banco de dados e salva o registro do usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();



            //redireciona para a pagina inicial
            return $this->redirectToRoute('inicio');

        }
        //renderiza o template com o formulario
        return $this->render('registro_usuario/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
