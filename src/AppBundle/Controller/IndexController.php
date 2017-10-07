<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findByStatus(1);
        return $this->render('AppBundle:Index:index.html.twig', array(
            'category' => $category
        ));
    }

    /**
     * @Route("/category/{slug}", name="category")
     */
    public function categoryAction($slug)
    {
        $criteria = array_filter(array('status' => 1, 'slug' => $slug));

        $category = $this->getDoctrine()->getRepository(Category::class)->findBy($criteria);
        $category = reset($category);
        
        return $this->render('AppBundle:Index:category.html.twig', array(
            'category' => $category
        ));
    }

    /**
     * @Route("/{category}/{slug}/detail", name="post_detail")
     */
    public function postDetailAction($slug)
    {
        $post = $this->getDoctrine()->getRepository(BlogPost::class)->findBySlug($slug);
        $post = reset($post);

        return $this->render('AppBundle:Index:post_detail.html.twig', array(
            'post' => $post
        ));
    }

}
