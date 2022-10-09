<?php

namespace App\Controller;

use App\Entity\BluelineSymfony;
use App\Form\ProduitType;
use App\Repository\BluelineSymfonyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProduitsController extends AbstractController
{
    /**
     * @Route("/produits", name="app_produits",methods={"GET"})
     * @param PaginatorInterface $paginator
     */
    public function index(BluelineSymfonyRepository $bluelineSymfonyRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            //On recupere tous les articles
            $bluelineSymfonyRepository->findAll(),
            //On liste par entier(knp_paginator.yaml) on définit la clef dans l'url, par defaut ma page 1 + nombre d'articles a afficher (ici 3)
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('produits/index.html.twig', [
            'controller_name' => 'ProduitsController',
            'produit' => $bluelineSymfonyRepository->findAll(),
            'dernierProduit' =>$bluelineSymfonyRepository->getDernierProduit(),
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/produits/new", name="app_produit_new",methods={"GET", "POST"})
     * 
     */
    public function new(Request $request, BluelineSymfonyRepository $bluelineSymfonyRepository): Response
    {
        $produit = new BluelineSymfony();
        //Création du formulaire
        //Creer le formulaire = la methode createForm prend 2 paramètres
        //AnnonceType spécifié la création et les paramètre du formulaire
        // en second paramètre: on accède a l'entity annonce et Getter et Setters
        $formulaire = $this->createForm(ProduitType::class, $produit);
        //Récupérer les champs(input values) du formulaire entré par l'utilisateur
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            // récupération de la propriété privée de l'image dans l'entity
            $image = $formulaire['photo']->getData();
            $imageCard = $formulaire['photoCarte']->getData();
            //si la valeur du champ n'est pas de type chaine de caractère
            if (!is_string($image) && !is_string($imageCard)) {
                //On récupere le nom du fichier uploader
                $NomImage = $image->getClientOriginalName();
                $NomImage2 = $imageCard->getClientOriginalName();
                //déplacement de la photo = move_uploader_file($_FILES['userfile']['tmp-name'] en php)
                $image->move(
                    $this->getParameter("images_directory"),
                    $NomImage
                );
                $imageCard->move(
                    $this->getParameter("images_directory"),
                    $NomImage2
                );
                //Attribution de la photo a l'entity a l'aide des Setters
                $produit->setPhoto($NomImage);
                $produit->setPhotoCarte($NomImage2);
                //notification flash bag
                $this->addFlash('Success', 'Votre annonce à bien été ajouté !');
            } else {
                //Sinon notif d'erreur
                $this->addFlash('Danger', 'Une erreur est survenue durant la création de votre annonce !!!');
                return $this->redirect($this->generateUrl('app_produit_new'));
            }
            //La requète DQL INERT INTO
            $bluelineSymfonyRepository->add($produit, true);
            //Redirection vers la page d'accueil
            return $this->redirectToRoute('app_produits', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('produits/new.html.twig', [
            'produit' => $produit,
            'formulaire' => $formulaire,
        ]);
    }

    /**
     * @Route("/produits/{id}", name="app_produit_afficher",methods={"GET"})
     */
    public function details(BluelineSymfony $bluelineSymfony, BluelineSymfonyRepository $bluelineSymfonyRepository): Response
    {
        return $this->render('produits/detail.html.twig', [
            'detail' => $bluelineSymfony,
            'details' => $bluelineSymfonyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/produits/{id}/edit", name="app_produit_edit",methods={"GET", "POST"})
     * 
     */
    public function edit(BluelineSymfony $bluelineSymfony, Request $request, BluelineSymfonyRepository $bluelineSymfonyRepository): Response
    {
        //recup de la photo courante
        //recup de l'image avec le getter
        $image = $bluelineSymfony->getPhoto();
        $image1 = $bluelineSymfony->getPhotoCarte();
        //Creation du formulaire
        // En paramètre on passe le formulaire ProduitsType et en 2nd l'entité
        $formulaire = $this->createForm(ProduitType::class, $bluelineSymfony);
        //Recuperation des champs (input) du formulaire d'edition
        $formulaire->handleRequest($request);
        //si le formulaire est soumis et validé
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            //traitement du fichier upload
            $file = $formulaire['photo']->getData();
            $file2 = $formulaire['photoCarte']->getData();
            if (!is_string($file) && !is_string($file2)) {
                $fileName = $file->getClientOriginalName();
                $fileName2 = $file2->getClientOriginalName();
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
                $file2->move(
                    $this->getParameter('images_directory'),
                    $fileName2
                );
                $bluelineSymfony->setPhoto($fileName);
                $bluelineSymfony->setPhotoCarte($fileName2);
                $this->addFlash('Success', 'Votre photo à bien été modifiée !');
            } else {
                $bluelineSymfony->setPhoto($image);
                $bluelineSymfony->setPhotoCarte($image1);
            }
            //DQL update et sauvegarde
            $bluelineSymfonyRepository->add($bluelineSymfony, true);

            return $this->redirectToRoute('app_produits', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('produits/edit.html.twig', [
            'produit' => $bluelineSymfony,
            'formulaire' => $formulaire,
        ]);
    }
    /**
     * @Route("/produits/{id}", name="app_produit_delete", methods={"POST"})
     */
    public function delete(Request $request, BluelineSymfony $bluelineSymfony, BluelineSymfonyRepository $bluelineSymfonyRepository): Response
    {
        //Check le _token du fichier delete_form.html.twig
        if ($this->isCsrfTokenValid('delete' . $bluelineSymfony->getId(), $request->request->get('_token'))) {
            // si ça match on supprime le produit de l'entité
            $bluelineSymfonyRepository->remove($bluelineSymfony, true);
        }
        //On effectue une redirection vers la page produit
        return $this->redirectToRoute('app_produits', [], Response::HTTP_SEE_OTHER);
    }
}
