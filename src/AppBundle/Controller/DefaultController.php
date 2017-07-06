<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $applications = $this->getDoctrine()
                            ->getRepository('AppBundle:Applications')
                            ->findAll();

        $solutions = [];
        $emails    = [];
        $errors    = [];

        if ($request->isMethod('POST')) {
            $app   = $request->request->get('app');
            $error = $request->request->get('error');
            $error = preg_replace("/^\s+/", "", $error);
            $error = preg_replace("/\s+$/", "", $error);
            $error = preg_replace("/\s/", " | ", $error);

            if ($app && $error) {
                $sql = "
                    SELECT * FROM application_errors a
                        JOIN error_solutions USING(error_id)
                    WHERE application_id = $app AND to_tsvector(error) @@ to_tsquery('$error')
                ";
                $stmt = $this->getDoctrine()->getEntityManager()->getConnection()->prepare($sql);
                $stmt->execute();

                $result = $stmt->fetchAll();

                foreach ($result as $solution) {
                    $solutions[] = $solution['solution'];
                    $errors[$solution['error']]  = $solution['error'];
                    $emails[$solution['notify']] = $solution['notify'];
                }
            }
        }

        return $this->render('default/index.html.twig', [
            'applications'  => $applications,
            'solutions'     => $solutions,
            'emails'        => $emails,
            'errors'        => $errors
        ]);
    }
}
