<?php

namespace Frontend\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SearchController extends Controller
{

    /**
     * @Route("/search", name="frontend.search.index")
     * @Template()
     */
    public function indexAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $query = $request->query->get('query');
        return [
            'repo' => $this->getQuery(explode(" ", mysql_escape_string($query)))
        ];
    }

    private function getQuery($elements = array())
    {
        if (!count($elements)) {
            return null;
        }
        /* @var $em ObjectManager|AbstractManagerRegistry */
        $em         = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $query      = "SELECT `am`.`id`, concat(`am`.`name`, ' ', `att`.`name`) as new_name FROM abstynencja.therapist att JOIN abstynencja.therapist_has_movies athm ON athm.movies_id = att.id JOIN abstynencja.movies am ON am.id = athm.therapist_id";
        $addition   = [];
        foreach ($elements as $element) {
            $addition[] = " concat(`am`.`name`, ' ', `att`.`name`) LIKE '%".$element."%'";
        }
        $query .= " WHERE".implode(" AND ", $addition);
        $statement = $connection->prepare($query);

        $statement->execute();
        $results   = $statement->fetchAll();
        $ids       = [];
        foreach ($results as $id) {
            $ids[] = $id['id'];
        }
        
        if(count($ids) === 0){
            return null;
        }
        $repo = $em->getRepository('Frontend\FrontendBundle\Entity\Movies')->findBy(['id' => $ids]);
        return $repo;
    }
}