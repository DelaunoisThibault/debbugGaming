<?php

namespace App\Controller;

use App\Entity\Bug;
use App\Repository\BugRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchFormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Knp\Component\Pager\PaginatorInterface;

class SearchNavController extends AbstractController
{
    /**
     * @Route("/search/nav", name="search_nav")
     */
    public function index(): Response
    {
        return $this->render('search_nav/index.html.twig', [
            'controller_name' => 'SearchNavController',
        ]);
    }

    public function searchBar()
    {
        $searchForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearch'))
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'searchText',
                    'placeholder' => 'Rechercher...'
                ]
            ])
           /* ->add('recherche', SubmitType::class, [
                'attr' => [
                    'class' => 'main-button headerSearchBarButton'
                ]
            ]) */
            ->getForm();
        return $this->render('search_nav/searchBar.html.twig', [
            'searchForm' => $searchForm->createView()
        ]);
    }

    /**
     * @Route("/handleSearch", name="handleSearch")
     * @param Request $request
     */
    public function handleSearch(Request $request, PaginatorInterface $paginator, BugRepository $repo): Response
    {
        $searchBugData = new Bug();
        $bugSearchForm = $this->createForm(SearchFormType::class, $searchBugData);
        $bugSearchForm->handleRequest($request);
        $bugs = $repo->findAllPublishedByRecent();
        $query = $request->request->get('form')['query'];
        if($query) {
            $bugs = $repo->findBugsByTitleOrDescription($query);
        }
        if($bugSearchForm->isSubmitted() && $bugSearchForm->isValid()){
            $bugs = $repo->searchDatas($searchBugData);

            if ($bugs == null) {
                $this->addFlash('erreur', 'Aucun article contenant ce mot clé dans le titre n\'a été trouvé, essayez en un autre.');

            }
        }

        $bugs = $paginator->paginate(
            $bugs,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('pages/searchBug.html.twig', [
            'pageTitle' => 'Rechercher un bug',
            'listBugs' => $bugs,
            'searchBugForm' => $bugSearchForm->createView()
        ]);
    }
}
