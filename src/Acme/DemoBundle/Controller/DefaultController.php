<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Cmf\Bundle\SimpleCmsBundle\Doctrine\Phpcr\Page;
use Acme\DemoBundle\Form\Type\PageType;

class DefaultController extends Controller
{
    /**
     * @return Response
     */
    public function loginAction()
    {
        return $this->redirect('/', 301);
    }

    /**
     * @return Response
     */
    public function logoutAction()
    {
        $token = $this->get('security.context')->getToken();
        $token->setAuthenticated(false);
        $this->get('request')->getSession()->invalidate();

        return $this->redirect('/', 301);
    }

    /**
     * @return Response
     */
    public function addPageAction(Request $request, $parentId)
    {
        //$page = new Page();
        $form = $this->createForm(new PageType());

        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager = $this->get('doctrine_phpcr.odm.document_manager');
            $parentPage = $manager->find(null, $parentId);
            $page = new Page();
            $page->setTitle($form->get('title')->getData());
            $page->setLabel($form->get('label')->getData());
            $page->setBody($form->get('title')->getData() . '.');
            $page->setDefault('_template', 'AcmeDemoBundle::work.detail.html.twig');
            $page->setPosition($parentPage, $form->get('title')->getData());
            $manager->persist($page);
            $manager->flush();
        }

        return $this->render('AcmeDemoBundle:Admin:add.page.html.twig', array(
                'parentId' => $parentId,
                'form' => $form->createView(),
            ));
    }
}