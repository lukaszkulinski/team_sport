<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Activity;
use Doctrine\ORM\QueryBuilder;
use App\Entity\ActivityParticipant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ActivityParticipantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ActivityParticipant::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->renderContentMaximized()
            ->setEntityLabelInSingular('Activity participant')
            ->setEntityLabelInPlural('Activity participants')
            ->setPageTitle('index', '%entity_label_plural% listing')
            ->setPageTitle('new', 'New %entity_label_singular%')
            ->setPageTitle('detail', fn (ActivityParticipant $activityParticipant) => (string) $activityParticipant)
            ->setPageTitle('edit', fn (ActivityParticipant $activityParticipant) => sprintf('Editing <b>%s</b>', $activityParticipant->getUser()->getEmail()))
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
        yield AssociationField::new('activity')->setQueryBuilder(
            fn (QueryBuilder $qb) => 
                $qb->andWhere('entity.active = :active')
                    ->setParameter('active', true)
        );
        yield AssociationField::new('user')->setQueryBuilder(
            fn (QueryBuilder $qb) => 
                $qb->andWhere('entity.active = :active')
                    ->setParameter('active', true)
        );
        yield BooleanField::new('active')->renderAsSwitch(false);
        yield BooleanField::new('admin')->hideOnIndex();

    }
}