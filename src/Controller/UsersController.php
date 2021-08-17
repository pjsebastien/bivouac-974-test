<?php

namespace App\Controller;

use App\Entity\Bivouac;
use App\Entity\Tag;
use App\Entity\Images;
use App\Form\BivouacsType;
use App\Form\EditProfileType;
use App\Repository\BivouacRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(BivouacRepository $bivouacRepo): Response
    {
        return $this->render('users/index.html.twig', [
            'totalBivouac' => $bivouacRepo->findAll(),
        ]);
    }
    /**
     * @Route("/users/bivouacs/ajout", name="users_bivouacs_ajout")
     */
    public function ajoutBivouac(Request $request, MailerInterface $mailer)
    {
        $bivouac = new Bivouac;

        $form = $this->createForm(BivouacsType::class, $bivouac);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $images = $form->get('images')->getData();
            

            foreach($images as $image){
                $file = md5(uniqid()).'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $file
                );
                $img = new Images();
                $img->setName($file);
                $bivouac->addImage($img);
            }


            $bivouac->setUsers($this->getUser());
            $bivouac->setActive(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($bivouac);
            $em->flush();

            $email = (new TemplatedEmail())
                ->from('pj.sebastien@gmail.com')
                ->to('pj.sebastien@gmail.com')
                ->subject('Nouveau spot dans bivouac974')
                ->htmlTemplate('emails/ajoutspot.html.twig');
            $mailer->send($email);

            $this->addFlash('message', 'Votre spot à bien été envoyer, il sera ajouté après verification par notre équipe !');

            return $this->redirectToRoute('users');
        }
        
        return $this->render('users/bivouacs/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
    /**
     * @Route("users/bivouacs/modifier/{id}", name="users_bivouacs_modifier")
     */
    public function ModifBivouac(Bivouac $bivouac ,Request $request)
    {

        $form = $this->createForm(BivouacsType::class, $bivouac);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($bivouac);
            $em->flush();

            return $this->redirectToRoute('admin_bivouacs_home');
        }

        return $this->render('users/bivouacs/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/users/profil/modif", name="users_profil_modifier")
     */
    public function editProfile( Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Profil mis à jour');

            return $this->redirectToRoute('users');
        }

        
        return $this->render('users/editProfile.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/users/pass/modifier", name="users_pass_modifier")
     */
    public function editPass(Request $request,  UserPasswordEncoderInterface $passwordEncoder)
    {
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();

            //On verifie si les 2 mots de passes sont identiques
            if($request->request->get('pass') == $request->request->get('pass2')){
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('pass')));
                $em->flush();
                $this->addFlash('message', 'Mot de passe mis à jour avec succès !');
                return $this->redirectToRoute('users');

            }else{
                $this->addFlash('error', 'les 2 mots de passes ne sont pas identiques');
            }
        }
        
        return $this->render('users/editPass.html.twig');
    }
}
