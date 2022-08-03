<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\UserInformation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('Poll');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::section('User'),
            MenuItem::linkToCrud('User', 'fa fa-tags', User::class),
            MenuItem::linkToCrud('User Information', 'fa fa-tags', UserInformation::class),
        ];
    }
}
