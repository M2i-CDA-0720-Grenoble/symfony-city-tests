<?php

namespace App\Controller;

use App\Entity\City;
use App\Form\CityType;
use App\Form\CityDistanceType;
use App\Repository\CityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/city")
 */
class CityController extends AbstractController
{
    /**
     * @Route("/distance", name="distance_form", methods={"GET"})
     */
    public function distanceForm(): Response
    {
        $form = $this->createForm(CityDistanceType::class);

        return $this->render('city/distance.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/distance", name="distance", methods={"POST"})
     */
    public function distance(Request $request): Response
    {
        $form = $this->createForm(CityDistanceType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $city1 = $data['city1'];
            $city2 = $data['city2'];
            $distance = $city1->getDistanceFrom($city2);

            $this->addFlash('info', $city1->getName() . ' is ' . sprintf("%01.1f", $distance) . 'km away from ' . $city2->getName());
        }

        return $this->render('city/distance.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/", name="city_index", methods={"GET"})
     */
    public function index(CityRepository $cityRepository): Response
    {
        return $this->render('city/index.html.twig', [
            'cities' => $cityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="city_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $city = new City();
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($city);
            $entityManager->flush();

            return $this->redirectToRoute('city_index');
        }

        return $this->render('city/new.html.twig', [
            'city' => $city,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="city_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(City $city): Response
    {
        return $this->render('city/show.html.twig', [
            'city' => $city,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="city_edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, City $city): Response
    {
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('city_index');
        }

        return $this->render('city/edit.html.twig', [
            'city' => $city,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="city_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, City $city): Response
    {
        if ($this->isCsrfTokenValid('delete'.$city->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($city);
            $entityManager->flush();
        }

        return $this->redirectToRoute('city_index');
    }
}
