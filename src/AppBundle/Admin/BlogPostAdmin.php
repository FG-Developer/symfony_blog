<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class BlogPostAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {

        $image = $this->getSubject();

        $fileFieldOptions = array('required' => false);
        if ($image && ($webPath = $image->getImage())) {

            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $container->get('request_stack')->getCurrentRequest()->getBasePath().'/'.$webPath;

            $fileFieldOptions['help'] = '<img src="'.$fullPath.'" class="admin-preview" />';
        }


        $formMapper->add('category_id', 'entity', array(
            'class' => 'AppBundle\Entity\Category',
            'property' => 'title',
        ));

        $formMapper->add('title', 'text', array(
            'label' => 'Blog Title'
        ));

        $formMapper->add('body', 'textarea', array(
            'attr' => array('class' => 'ckeditor')
        ));

        $formMapper->add('slug', 'text', array(
            'label' => 'Blog Slug'
        ));

        $formMapper->add('file', 'file', $fileFieldOptions);

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
        ->add('slug')
        ->add('category', null, array(), 'entity', array(
            'class'    => 'AppBundle\Entity\Category',
            'property' => 'title'
        ));
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
