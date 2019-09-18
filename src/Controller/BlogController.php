<?php

namespace App\Controller;

use App\Entity\BlogEntry;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog", methods={"GET"})
     */
    public function index()
    {
        $blogEntities = $this->getDoctrine()->getRepository(BlogEntry::class)->findAll();

        return new JsonResponse($blogEntities);

    }

    /**
     * @Route("/blog/{id}", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $blogEntity = $this->getDoctrine()->getRepository(BlogEntry::class)->find($id);

        if(is_null($blogEntity)){
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($blogEntity);
    }

    /**
     * @Route("/blog/{id}", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        try {
            $this->getDoctrine()->getRepository(BlogEntry::class)->delete($id);
            return new JsonResponse("Deleted", Response::HTTP_OK);
        } catch (ORMException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

    }

    /**
     * @Route("/blog/{id}", methods={"PUT"})
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function edit(int $id, Request $request)
    {
        $blogEntity = $this->getDoctrine()->getRepository(BlogEntry::class)->find($id);
        if(is_null($blogEntity))
        {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $blogEntity->setName($request->request->get("title"));
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse("Updated", Response::HTTP_CREATED);


    }

    /**
     * @Route("/blog", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $blogEntity = new BlogEntry();
        $blogEntity->setTitle($request->request->get("title"));
        $blogEntity->setDescription($request->request->get("description"));

        $this->getDoctrine()->getManager()->persist($blogEntity);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse($blogEntity, Response::HTTP_CREATED);

    }
}
