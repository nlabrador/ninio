<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Applications;
use AppBundle\Entity\ApplicationErrors;
use AppBundle\Entity\ErrorSolutions;

class ApplicationController extends Controller
{
    /**
     * @Route("/application/new", name="newapplication")
     */
    public function newapplicationAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $desc = $request->request->get('description');

            if ($name && $desc) {
                $app = new Applications();

                $app->setName($name);
                $app->setDescription($desc);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($app);
                $em->flush();
            
                return $this->redirectToRoute("applicationsetup", ['id' => $app->getApplicationId()]);
            }
        }

        return $this->render('application/new.html.twig');
    }

    /**
     * @Route("/application", name="applicationlist")
     */
    public function applicationlistAction(Request $request)
    {
        $applications = $this->getDoctrine()
                            ->getRepository('AppBundle:Applications')
                            ->findAll();

        return $this->render('application/list.html.twig', [
            'applications'  => $applications
        ]);
    }

    /**
     * @Route("/application/setup/{id}", name="applicationsetup")
     */
    public function applicationsetupAction($id, Request $request)
    {
        $application = $this->getDoctrine()
                                ->getRepository('AppBundle:Applications')
                                ->find($id);

        if ($request->isMethod('POST')) {
            $error  = $request->request->get('error');
            $notify = $request->request->get('notify');

            if ($error && $notify) {
                $app_error = new ApplicationErrors();

                $app_error->setError($error);
                $app_error->setNotify($notify);
                $app_error->setApplication($application);

                $em = $this->getDoctrine()->getManager();
                $em->persist($app_error);
                $em->flush();
                
                return $this->redirectToRoute("applicationsolutions", ['id' => $app_error->getErrorId()]);
            }
            else {
                return $this->redirectToRoute("applicationsetup", ['id' => $id]);
            }
        }
        else {
            $errors = $this->getDoctrine()
                            ->getRepository('AppBundle:ApplicationErrors')
                            ->findBy(['application' => $application]);

            return $this->render('application/setup.html.twig', [
                'errors'        => $errors,
                'application'   => $application
            ]);
        }
    }

    /**
     * @Route("/application/solutions/{id}", name="applicationsolutions")
     */
    public function applicationsolutionsAction($id, Request $request)
    {
        $error = $this->getDoctrine()
                            ->getRepository('AppBundle:ApplicationErrors')
                            ->find($id);

        if ($request->isMethod('POST')) {
            $solution  = $request->request->get('solution');

            if ($solution) {
                $error_sol = new ErrorSolutions();

                $error_sol->setError($error);
                $error_sol->setSolution($solution);

                $em = $this->getDoctrine()->getManager();
                $em->persist($error_sol);
                $em->flush();
            }
            
            return $this->redirectToRoute("applicationsolutions", ['id' => $id]);
        }
        else {
            $solutions = $this->getDoctrine()
                            ->getRepository('AppBundle:ErrorSolutions')
                            ->findBy(['error' => $error]);
        
            return $this->render('application/solutions.html.twig', [
                'error'     => $error,
                'solutions' => $solutions
            ]);
        }
    }

    /**
     * @Route("/application/errorupdate/{id}", name="errorupdate")
     */
    public function errorupdateAction($id, Request $request)
    {
        $app_error = $this->getDoctrine()
                            ->getRepository('AppBundle:ApplicationErrors')
                            ->find($id);

        if ($request->isMethod('POST')) {
            $error  = $request->request->get('error');
            $notify = $request->request->get('notify');

            if ($error && $notify) {
                $app_error->setError($error);
                $app_error->setNotify($notify);

                $em = $this->getDoctrine()->getManager();
                $em->persist($app_error);
                $em->flush();
            }
            
            return $this->redirectToRoute("applicationsetup", ['id' => $id]);
        }
        else {
            return $this->render('application/errorupdate.html.twig', [
                'error'  => $app_error
            ]);
        }
    }
}
