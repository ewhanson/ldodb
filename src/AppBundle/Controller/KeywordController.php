<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Keyword;
use AppBundle\Form\KeywordType;

/**
 * Keyword controller.
 *
 * @Route("/keyword")
 */
class KeywordController extends Controller {

    /**
     * Lists all Keyword entities.
     *
     * @Route("/", name="keyword_index")
     * @Method("GET")
     * @Template()
     * @param Request $request
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(Keyword::class, 'e')->orderBy('e.keyword', 'ASC');
        $query = $qb->getQuery();
        $paginator = $this->get('knp_paginator');
        $keywords = $paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'keywords' => $keywords,
        );
    }

    /**
     * Search for Keyword entities.
     *
     * To make this work, add a method like this one to the 
     * AppBundle:Keyword repository. Replace the fieldName with
     * something appropriate, and adjust the generated search.html.twig
     * template.
     * 
      //    public function searchQuery($q) {
      //        $qb = $this->createQueryBuilder('e');
      //        $qb->where("e.fieldName like '%$q%'");
      //        return $qb->getQuery();
      //    }
     *
     *
     * @Route("/search", name="keyword_search")
     * @Method("GET")
     * @Template()
     * @param Request $request
     */
    public function searchAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Keyword');
        $q = $request->query->get('q');
        if ($q) {
            $query = $repo->searchQuery($q);
            $paginator = $this->get('knp_paginator');
            $keywords = $paginator->paginate($query, $request->query->getInt('page', 1), 25);
        } else {
            $keywords = array();
        }

        return array(
            'keywords' => $keywords,
            'q' => $q,
        );
    }

    /**
     * Full text search for Keyword entities.
     *
     * To make this work, add a method like this one to the 
     * AppBundle:Keyword repository. Replace the fieldName with
     * something appropriate, and adjust the generated fulltext.html.twig
     * template.
     * 
      //    public function fulltextQuery($q) {
      //        $qb = $this->createQueryBuilder('e');
      //        $qb->addSelect("MATCH_AGAINST (e.name, :q 'IN BOOLEAN MODE') as score");
      //        $qb->add('where', "MATCH_AGAINST (e.name, :q 'IN BOOLEAN MODE') > 0.5");
      //        $qb->orderBy('score', 'desc');
      //        $qb->setParameter('q', $q);
      //        return $qb->getQuery();
      //    }
     * 
     * Requires a MatchAgainst function be added to doctrine, and appropriate
     * fulltext indexes on your Keyword entity.
     *     ORM\Index(name="alias_name_idx",columns="name", flags={"fulltext"})
     *
     *
     * @Route("/fulltext", name="keyword_fulltext")
     * @Method("GET")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function fulltextAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Keyword');
        $q = $request->query->get('q');
        if ($q) {
            $query = $repo->fulltextQuery($q);
            $paginator = $this->get('knp_paginator');
            $keywords = $paginator->paginate($query, $request->query->getInt('page', 1), 25);
        } else {
            $keywords = array();
        }

        return array(
            'keywords' => $keywords,
            'q' => $q,
        );
    }

    /**
     * Creates a new Keyword entity.
     *
     * @Route("/new", name="keyword_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_CONTENT_ADMIN')")
     * @Template()
     * @param Request $request
     */
    public function newAction(Request $request) {
        $keyword = new Keyword();
        $form = $this->createForm(KeywordType::class, $keyword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($keyword);
            $em->flush();

            $this->addFlash('success', 'The new keyword was created.');
            return $this->redirectToRoute('keyword_show', array('id' => $keyword->getId()));
        }

        return array(
            'keyword' => $keyword,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Keyword entity.
     *
     * @Route("/{id}", name="keyword_show")
     * @Method("GET")
     * @Template()
     * @param Keyword $keyword
     */
    public function showAction(Keyword $keyword) {

        return array(
            'keyword' => $keyword,
        );
    }

    /**
     * Displays a form to edit an existing Keyword entity.
     *
     * @Route("/{id}/edit", name="keyword_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_CONTENT_ADMIN')")
     * @Template()
     * @param Request $request
     * @param Keyword $keyword
     */
    public function editAction(Request $request, Keyword $keyword) {
        $editForm = $this->createForm(KeywordType::class, $keyword);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'The keyword has been updated.');
            return $this->redirectToRoute('keyword_show', array('id' => $keyword->getId()));
        }

        return array(
            'keyword' => $keyword,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Keyword entity.
     *
     * @Route("/{id}/delete", name="keyword_delete")
     * @Method("GET")
     * @Security("has_role('ROLE_CONTENT_ADMIN')")
     * @param Request $request
     * @param Keyword $keyword
     */
    public function deleteAction(Request $request, Keyword $keyword) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($keyword);
        $em->flush();
        $this->addFlash('success', 'The keyword was deleted.');

        return $this->redirectToRoute('keyword_index');
    }

}
