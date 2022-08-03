<?php

namespace App\Controller\Admin;

use App\Entity\UserInformation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserInformationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserInformation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username'),
        ];
    }
}
