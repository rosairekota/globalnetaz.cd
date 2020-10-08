<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use App\Notification\ContactNotification;
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

        return $this->render('property_new/index.html.twig', [
            'current_menu'      => 'property_index',
            'properties'        => $properties,
            'form_search'      => $form_search->createView()
        ]);
        // $this->em->flush();

    }

    /**
     * @Route("/biens/{slug}-{id}", name="property_show", requirements={"slug":"[a-z0-9\-]*"})
     */
    public function show(Property $property, string $slug, Request $request,ContactNotification  $notification)
    {


        // on fait une verification du slug
        if ($property->getSlug() != $slug) {
            return $this->redirectToRoute('property_show', [
                'id'   => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        $contact = new Contact();
        $contact->setProperty($property);
        $form_contact = $this->createForm(ContactType::class, $contact);
        $form_contact->handleRequest($request);
        if ($form_contact->isSubmitted() && $form_contact->isValid()) {
            // Envoi de l'email:
              $notification->notify($contact);
            $this->addFlash("success", "Votre email a bien été envoyé");
            return $this->redirectToRoute('property_show', [
                'id'   => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('property_new/show.html.twig', [
            'current_menu' => 'property_index',
            'property'    => $property,
            'form_contact'    => $form_contact->createView()
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
