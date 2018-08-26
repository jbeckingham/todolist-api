<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Item;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends Controller {

    /**
     * @Route("/items")
     * @Method("POST")
     */
    public function addAction(Request $request) {

        $itemName = $request->request->get('item');

        $item = new Item();
        $item->setName($itemName);
        $item->setCompleted(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($item);
        $em->flush();

        $results = [];
        $results = [
            'id' => $item->getId()
        ];
        return new Response(json_encode($results));
    }

    /**
      * @Route("/items")
      * @Method("GET")
      * @return Response
      */
    public function getAllAction()
    {
        $items = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Item')
            ->findAll();

        foreach ($items as $item) {
            $data[] = array(
                'id' => $item->getId(),
                'name' => $item->getName(),
                'completed' => $item->getCompleted());
        }

        return new Response(json_encode($data));
    }
    /**
     * @Route("/items/{id}")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        $item = $this->getDoctrine()->getRepository('AppBundle:Item')->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        return new Response("Success");
    }
}
