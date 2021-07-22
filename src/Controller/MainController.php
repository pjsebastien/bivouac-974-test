<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Form\ContactType;
use App\Form\SearchBivouacType;
use App\Repository\BivouacRepository;
use App\Repository\CommentRepository;
use App\Repository\TagRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(BivouacRepository $bivouacRepo, TagRepository $tagsRepo, CommentRepository $commentRepo, Request $request): Response
    {
        $bivouac = $bivouacRepo->findBy(['active' => true], ['created_at' => 'desc'], 9);
        $form = $this->createForm(SearchBivouacType::class);
        $search = $form->handleRequest($request);
        

        if($form->isSubmitted() && $form->isValid()){
            $bivouac = $bivouacRepo->search(
                $search->get('mots')->getData(),
                $search->get('categorie')->getData()
                
        );
        }

        return $this->render('main/index.html.twig', [
            'bivouacs' => $bivouac ,
            'tag' => $tagsRepo->findAll(),
            'totalBivouac' => $bivouacRepo->findAll(),
            'form' => $form->createView(),
            

            //dd($tagsRepo->findAll())
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $contact = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('pj.sebastien@gmail.com')
                ->subject('Contact de bivouac974')
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'mail' => $contact->get('email')->getData(),
                    'sujet' => $contact->get('sujet')->getData(),
                    'message' => $contact->get('message')->getData()
                ]);
            $mailer->send($email);

            $this->addFlash('message', 'Votre email à bien été envoyé !');
            return $this->redirectToRoute('contact');
        }
        return $this->render('main/contact.html.twig', [
            'form' => $form->createView()
        ]);

        
    }

    
}
