<?php

namespace App\Controller\Admin;

use App\Entity\Activity;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ActivityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Activity::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->renderContentMaximized()
            ->setEntityLabelInSingular('Activity')
            ->setEntityLabelInPlural('Activities')
            ->setPageTitle('index', '%entity_label_plural% listing')
            ->setPageTitle('new', 'New %entity_label_singular%')
            ->setPageTitle('detail', fn (Activity $activity) => (string) $activity)
            ->setPageTitle('edit', fn (Activity $activity) => sprintf('Editing <b>%s</b>', $activity->getName()))
            ->setHelp('edit', '...')
            ->setSearchFields(['name', 'description'])
            ->setAutofocusSearch()
            ->setDefaultSort(['id' => 'DESC'])
            ->setPaginatorPageSize(30)
            ->setPaginatorRangeSize(4)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('name');
        yield AssociationField::new('participants')->onlyOnIndex();
        yield CollectionField::new('participants')->useEntryCrudForm()->setEntryIsComplex()->renderExpanded()->hideOnIndex();
        yield BooleanField::new('active')->renderAsSwitch(false);
    }
}