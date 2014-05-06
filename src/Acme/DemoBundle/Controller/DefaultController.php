<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Cmf\Bundle\SimpleCmsBundle\Doctrine\Phpcr\Page;
use Symfony\Cmf\Component\Routing\ContentAwareGenerator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Doctrine\ODM\PHPCR\DocumentManager;
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
    public function addPageAction(Request $request)
    {
        //$page = new Page();
        $form = $this->createForm(new PageType());

        $request->get('title');
        $request->get('menu');

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

            return $this->redirect('/', 301);
        }

        return $this->render('AcmeDemoBundle:Admin:add.page.html.twig', array(
                'parentId' => $parentId,
                'form' => $form->createView(),
            ));
    }

    /**
     * @return Response
     */
    public function removePageAction(Request $request, $pageId)
    {
        $crHomepageBasepath = $this->container->getParameter('cr_homepage_basepath');

        if ($pageId == $crHomepageBasepath) {
            throw new BadRequestHttpException('Impossible eliminar la pàgina principal');
        }

        /** @var DocumentManager $manager */
        $manager = $this->get('doctrine_phpcr.odm.document_manager');

        /** @var Page $page */
        $page = $manager->find(null, $pageId);

        if (null === $page) {
            throw new BadRequestHttpException('La pàgina ' . $pageId . ' no existeix, impossible eliminar');
        }

        $manager->remove($page);
        $manager->flush();

        /** @var ContentAwareGenerator $rg */
        $rg = $this->get('cmf_routing.generator');

        return $this->redirect($rg->generate($crHomepageBasepath), 301);
    }
}