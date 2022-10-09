<?php

namespace App\Controller\Admin;

use App\Entity\BlogBlueline;
use App\Entity\BluelineSymfony;
use App\Entity\Categories;
use App\Entity\Distributeur;
use App\Entity\Reference;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(BluelineSymfonyCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Projet Blueline Symfony');
    }

    public function configureMenuItems(): iterable
    {

        return [
            MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home'),

            MenuItem::section('BlogBlueline'),
            MenuItem::linkToCrud('BlogBlueline', 'fa fa-user', BlogBlueline::class),

            MenuItem::section('BluelineSymfony'),
            MenuItem::linkToCrud('BluelineSymfony', 'fa fa-user', BluelineSymfony::class),

            MenuItem::section('Categories'),
            MenuItem::linkToCrud('Categories', 'fa fa-user', Categories::class),

            MenuItem::section('Distributeur'),
            MenuItem::linkToCrud('Distributeur', 'fa fa-user', Distributeur::class),

            MenuItem::section('Reference'),
            MenuItem::linkToCrud('Reference', 'fa fa-user', Reference::class),

            MenuItem::section('User'),
            MenuItem::linkToCrud('User', 'fa fa-user', User::class),
        ];
    }
}
