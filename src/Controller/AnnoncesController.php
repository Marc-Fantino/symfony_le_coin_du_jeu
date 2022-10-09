<?php

namespace App\Controller;

use App\Entity\BlogBlueline;
use App\Form\AnnonceType;
use App\Repository\BlogBluelineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class AnnoncesController extends AbstractController
{
    /**
     * @Route("/annonces", name="app_annonces")
     * @param PaginatorInterface $paginator
     */
    public function index(Request $request, BlogBluelineRepository $blogBluelineRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            //On recupere tous les articles
            $blogBluelineRepository->findAll(),
            //On liste par entier(knp_paginator.yaml) on définit la clef dans l'url, par defaut ma page 1 + nombre d'articles a afficher (ici 3)
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('annonces/index.html.twig', [
            'controller_name' => 'AnnoncesController',
            'annonce' => $blogBluelineRepository->findAll(),
            'pagination' => $pagination
        ]);
    }

    /**
     *@Route("/annonces/new", name="app_annonces_new", methods={"GET", "POST"})
     *
     */
    public function new(Request $request, BlogBluelineRepository $blogBluelineRepository): Response
    {
        $annonce = new BlogBlueline();
        //Création du formulaire
        //Creer le formulaire = la methode createForm prend 2 paramètres
        //AnnonceType spécifié la création et les paramètre du formulaire
        // en second paramètre: on accède a l'entity annonce et Getter et Setters
        $formulaireAnnonce = $this->createForm(AnnonceType::class, $annonce);
        //Récupérer les champs(input values) du formulaire entré par l'utilisateur
        $formulaireAnnonce->handleRequest($request);
        if ($formulaireAnnonce->isSubmitted() && $formulaireAnnonce->isValid()) {
            // récupération de la propriété privée de l'image dans l'entity
            $imageAnnonce = $formulaireAnnonce['photo']->getData();
            //si la valeur du champ n'est pas de type chaine de caractère
            if (!is_string($imageAnnonce)) {
                //On récupere le nom du fichier uploader
                $nomImageAnnonce = $imageAnnonce->getClientOriginalName();
                //déplacement de la photo = move_uploader_file($_FILES['userfile']['tmp-name'] en php)
                $imageAnnonce->move(
                    $this->getParameter("images_directory"),
                    $nomImageAnnonce
                );
                //Attribution de la photo a l'entity a l'aide des Setters
                $annonce->setPhoto($nomImageAnnonce);
                //notification flash bag
                $this->addFlash('Success', 'Votre annonce à bien été ajouté !');
            } else {
                //Sinon notif d'erreur
                $this->addFlash('Danger', 'Une erreur est survenue durant la création de votre annonce !!!');
                return $this->redirect($this->generateUrl('app_annonces_new'));
            }
            //La requète DQL INERT INTO
            $blogBluelineRepository->add($annonce, true);
            //Redirection vers la page d'accueil
            return $this->redirectToRoute('app_annonces', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('annonces/new.html.twig', [
            'annonce' => $annonce,
            'formulaire' => $formulaireAnnonce,
        ]);
    }
    /**
     * @Route("/annonces/{id}", name="app_annonce_afficher", methods={"GET"})
     */
    public function details(BlogBlueline $BlogBlueline): Response
    {
        return $this->render('annonces/detail_annonce.html.twig', [
            'detail_annonce' => $BlogBlueline,
        ]);
    }
    /**
     *@Route("/annonces/{id}/edit" , name="app_annonce_edit", methods={"GET", "POST"})
     *
     */
    public function edit(BlogBlueline $blogBlueline, Request $request, BlogBluelineRepository $blogBluelineRepository): Response
    {
        //recup de la photo courante
        //recup de l'image avec le getter
        $image = $blogBlueline->getPhoto();
        //Creation du formulaire
        // En paramètre on passe le formulaire ProduitsType et en 2nd l'entité
        $formulaire = $this->createForm(AnnonceType::class, $blogBlueline);
        //Recuperation des champs (input) du formulaire d'edition
        $formulaire->handleRequest($request);
        //si le formulaire est soumis et validé
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $file = $formulaire['photo']->getData();
            if (!is_string($file)) {
                $fileName = $file->getClientOriginalName();
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
                $blogBlueline->setPhoto($fileName);
                $this->addFlash('Success', 'Votre photo à bien été modifiée !');
            } else {
                $blogBlueline->setPhoto($image);
            }
            //DQL update et sauvegarde
            $blogBluelineRepository->add($blogBlueline, true);

            return $this->redirectToRoute('app_annonces', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('annonces/edit.html.twig', [
            'annonce' => $blogBlueline,
            'formulaire' => $formulaire,
        ]);
    }

    /**
     * @Route("/annonces/{id}", name="app_annonce_delete", methods={"POST"})
     */
    public function delete(Request $request, BlogBlueline $blogBlueline, BlogBluelineRepository $BlogBluelineRepository): Response
    {
        //Check le _token du fichier delete_form.html.twig
        if ($this->isCsrfTokenValid('delete' . $blogBlueline->getId(), $request->request->get('_token'))) {
            // si ça match on supprime le produit de l'entité
            $BlogBluelineRepository->remove($blogBlueline, true);
        }
        //On effectue une redirection vers la page annonce
        return $this->redirectToRoute('app_annonces', [], Response::HTTP_SEE_OTHER);
    }
}
