<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(Category::class);
        $categories = $em->getRepository(Category::class);

        $categories = $repository->findAll();
       /*  dd($repository);
        dump($repository); */




        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/{id}', name: 'app_category_show', methods:['GET', 'HEAD'])]
    public function show(category $category): Response
    {

       // $categorie = $em->getRepository(Category::class)->find($id);

        if (empty($category)) {
            throw $this->createNotFoundException(" cet id ne correspond à aucune catégories !");
        }

        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }


    #[Route('/category/{id}', name: 'app_category_edit', methods:['POST', 'PUT', 'PATCH'])]
    public function edit(EntityManagerInterface $em, category $category): Response
    {

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

        //Modification
       // dd('ok');

            $category = $form->getData();
            $em->flush();

            return $this->render('category/show.html.twig', [
                'category'=>$category,
            ]);


       $form = $this->createForm(CategoryType::class, $category);
       $form->handleRequest($request);

       
        return $this->render('category/edit.html.twig', [
            'category'=>$category,
        
            'form'=> $form,
        ]);
    }


    #[Route('/category/delete/{id}', name: 'app_category_delete', methods:['DELETE'])]
    public function delete(EntityManagerInterface $em, category $category): Response
    {
        //Supprimer la catégorie
        $em->remove($category);
        $em->flush();

        return $this->render('category/show.html.twig', [

        
            'category'=> $category,
        ]);
    }
 
}
