<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CategoryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title', 'text', array(
            'label' => 'Category Title'
        ));

        $formMapper->add('body', 'textarea', array(
            'attr' => array('class' => 'ckeditor')
        ));

        $formMapper->add('slug', 'text', array(
            'label' => 'Category Slug'
        ));

        $formMapper->add('status', 'choice', array(
            'choices' => array(
                1 => 'Active',
                0 => 'Inactive'
            )
        ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
      $datagridMapper->add('title')
      ->add('slug');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
      $listMapper->addIdentifier('id')
      ->add('title')
      ->add('slug')
      ->add('createdAt')
      ->add('_action', null, array(
          'actions' => array(
              'show' => array(),
              'edit' => array(),
              'delete' => array(),
          )
      ));
    }

    public function prePersist($image)
    {
        $this->manageFileUpload($image);
    }

    public function preUpdate($image)
    {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload($image)
    {
      $image->refreshUpdated();
    }
}
