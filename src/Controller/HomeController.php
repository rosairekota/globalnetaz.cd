<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private PropertyRepository $repo;
    public function __construct(PropertyRepository $repo)
    {
        $this->repo=$repo;
        
    }
    /**
     * @Route("/", name="home")
     */
    public function index(PropertyRepository $repo,CacheInterface $cache)
    {
        $mycache=$cache->get('properties',function(){
            return $this->repo->findLatest();
        });
        $properties=$this->repo->findLatest();

        return $this->render('property_new/home.html.twig',compact('properties'));
    }
}
