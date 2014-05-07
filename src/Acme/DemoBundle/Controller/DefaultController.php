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
use Acme\Tools\Tools;

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
        $crHomepageBasepath = $this->container->getParameter('cr_homepage_basepath');
        $parentId = $request->get('parent');
        $title = $request->get('title');
        $menu = $request->get('menu');

        if (empty($parentId) || empty($title) || empty($menu)) {
            throw new BadRequestHttpException('Impossible crear pàgina');
        }

        /** @var DocumentManager $manager */
        $manager = $this->get('doctrine_phpcr.odm.document_manager');

        /** @var Page $page */
        $parentPage = $manager->find(null, $parentId);

        if (null === $parentPage) {
            throw new BadRequestHttpException('La pàgina ' . $pageId . ' no existeix, impossible crear nova pàgina aquí');
        }

        if (null !== $manager->find(null, $parentId . '/' . Tools::getSlug($title))) {
            throw new BadRequestHttpException('La pàgina ' . $pageId . ' ja existeix aquí, impossible duplicar');
        }

        $page = new Page();
        $page->setTitle($title);
        $page->setLabel($menu);
        $page->setBody($title . '.');

        if ($parentId == $crHomepageBasepath) {
            // Nivell 1
            $page->setDefault('_template', 'AcmeDemoBundle:Page:index.html.twig');
        } else {
            // Nivell 2
            $parentPage->setDefault('_template', 'AcmeDemoBundle::works.html.twig');
            $manager->persist($parentPage);
            $page->setDefault('_template', 'AcmeDemoBundle::work.detail.html.twig');
        }

        $page->setPosition($parentPage, Tools::getSlug($title));
        $manager->persist($page);
        $manager->flush();

        /** @var ContentAwareGenerator $rg */
        $rg = $this->get('cmf_routing.generator');

        return $this->redirect($rg->generate($page->getId()), 301);
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