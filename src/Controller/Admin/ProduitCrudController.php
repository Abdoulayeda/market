<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            TextEditorField::new('description'),
            AssociationField::new('categorie'),

            TextField::new('imageFile', 'Upload' )
                ->setFormType(VichImageType::class)
                ->onlyWhenCreating(),
            ImageField::new('photo', 'Produit')
                ->setBasePath('/produits_images')
                ->hideOnForm(),

            IntegerField::new('prix'),
            BooleanField::new('vendu'),
            DateTimeField::new('created_at')->hideOnForm()
        ];
    }

}
