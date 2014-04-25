<?php

namespace Acme\DemoBundle\DataFixtures\PHPCR;

use Nelmio\Alice\Fixtures;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Cmf\Bundle\SimpleCmsBundle\Doctrine\Phpcr\Page;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;

/**
 * Loads the initial demo data of the demo website.
 */
class LoadDemoData implements FixtureInterface
{
    /**
     * Load data fixtures with the passed DocumentManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * contacte
         */
        /** @var Page $page */
        $rootPage = $manager->find(null, '/cms/simple');
        $page = new Page();
        $page->setParentDocument($rootPage);
        $page->setName('contacte');
        $page->setTitle('contacte');
        $page->setBody('contacte.');
        $page->setDefault('_template', 'AcmeDemoBundle:page:index.html.twig');
        $manager->persist($page);
        // menu
        $menuRoot = $manager->find(null, '/cms/simple');
        $menuNode = new MenuNode('contacte');
        $menuNode->setLabel('contacte');
        $menuNode->setParent($menuRoot);
        $menuNode->setContent($page);
        $manager->persist($menuNode);

        /**
         * treball recent
         */
        /** @var Page $page */
        $rootPage = $manager->find(null, '/cms/simple');
        $page = new Page();
        $page->setParentDocument($rootPage);
        $page->setName('treball-recent');
        $page->setTitle('treball recent');
        $page->setBody('trebal recent.');
        $page->setDefault('_template', 'AcmeDemoBundle::works.html.twig');
        $manager->persist($page);
        // menu
        $menuRoot = $manager->find(null, '/cms/simple');
        $menuNode = new MenuNode('treball-recent');
        $menuNode->setLabel('treball recent');
        $menuNode->setParent($menuRoot);
        $menuNode->setContent($page);
        $manager->persist($menuNode);

        // load the yaml file in src/Acme/DemoBundle/Resources/data/pages.yml
        //Fixtures::load(array(__DIR__.'/../../Resources/data/pages.yml'), $manager);

        // load the blocks
        //Fixtures::load(array(__DIR__.'/../../Resources/data/blocks.yml'), $manager);

        // save the changes
        $manager->flush();
    }
}
