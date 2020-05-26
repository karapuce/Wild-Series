<?php
// src/Controller/WildController.php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Entity\Season;
use phpDocumentor\Reflection\Types\Mixed_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wild", name="wild_")
 */
class WildController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()->getRepository(Program::class)->findAll();

        if (!$programs){
            throw $this->createNotFoundException(
                "No program found in program's table"
            );
        }

        return $this->render('wild/index.html.twig', [
            'programs' => $programs
        ]);
    }

    /**
     * @Route("/show/{slug}",
     *     requirements={"slug"="[a-z0-9-]+"},
     *     defaults={"slug"="Aucune série sélectionnée, veuillez choisir une série"},
     *     name="show")
     * @param string $slug
     * @return Response
     */
    public function show($slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with '.$slug.' title, found in program\'s table.'
            );
        }


        return $this->render('wild/show.html.twig', [
            'slug' => $slug,
            'program' => $program]);
    }

    /**
     * @Route("/category/{categoryName}", name="show_category")
     * @param string $categoryName
     * @return Response
     */
    public function showByCategory(string $categoryName) {

        $category = $this->getDoctrine()->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);

        $programs = $this->getDoctrine()->getRepository(Program::class)
            ->findBy(array('category' => $category), array ("id" => "desc") ,3 );


        return $this->render('wild/category.html.twig', [
            'category' => $categoryName,
            'programs' => $programs]);
    }

    /**
     * @Route("/showProgram/{slug}", name="show_program")
     * @param string $slug
     * @return Response
     */
    public function showByProgram(string $slug){
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $repoProgram = $this->getDoctrine()->getRepository(Program::class);

        $program = $repoProgram->findOneBy(['title'=>mb_strtolower($slug)]);

        $seasons = $program->getSeasons();

        return $this->render('wild/program.html.twig',
            ['slug' => $slug,
                'seasons' => $seasons,
                "program"=>$program
            ]);
    }

    /**
     * @Route("/showSeason/{id}", name="show_season")
     * @param int $id
     * @return Response
     */
    public function showBySeason(int $id)
    {

        $seasonRepo = $this->getDoctrine()->getRepository(Season::class);

        $season = $seasonRepo->find($id);
        $program = $season->getProgram();
        $episodes = $season->getEpisodes();

        return $this->render('wild/season.html.twig',
            [
                "season" => $season,
                "episodes" => $episodes,
                "program" => $program
            ]
        );
    }

}
