<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use Knp\Component\Pager\PaginatorInterface;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */

    private $repo;


    public function __construct(PropertyRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/biens", name="property_index")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $propertySearch = new PropertySearch();
        $form_search = $this->createForm(PropertySearchType::class, $propertySearch);
        $form_search->handleRequest($request);



        $query = $this->repo->findSearchPropertyQuery($propertySearch);
        $properties = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
        );

        return $this->render('pages/property/index.html.twig', [
            'current_menu'      => 'property_index',
            'properties'        => $properties,
            'form_search'      => $form_search->createView()
        ]);
        // $this->em->flush();

    }

    /**
     * @Route("/biens/{slug}-{id}", name="property_show", requirements={"slug":"[a-z0-9\-]*"})
     */
    public function show(Property $property, string $slug)
    {
        // on fait une verification du slug
        if ($property->getSlug() != $slug) {
            return $this->redirectToRoute('property_show', [
                'id'   => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('pages/property/show.html.twig', [
            'current_menu' => 'property_index',
            'property'    => $property,
        ]);
    }



    // MES HELPERS



    public function paginate(int $nombreEltBypage, $request, PropertyRepository $repo)
    {

        // $page=($_GET['paginate']?? 1);
        $page = $request;
        if (!filter_var($page, FILTER_VALIDATE_INT)) {
            die("La valeur decimal n'est acceptable\n\t");
        }

        $currentpage = (int) $page;

        if ($currentpage <= 0) {
            die("Numero de page invalide\n\t");
        }


        $sql = $repo->findAll();

        $property_number = \count($repo->findAll());
        $nombre_pages = ceil($property_number / $nombreEltBypage);
        if ($currentpage > $nombre_pages) {
            die("Cette page n'existe pas. \n\t");
        }
        $offset = $nombreEltBypage * ($currentpage - 1);
        //$properties=$QueryBuilder;
        return compact('nombre_pages', 'currentpage', 'offset');
    }
}
