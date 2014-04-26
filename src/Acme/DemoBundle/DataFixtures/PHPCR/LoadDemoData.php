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
        $homepage = $manager->find(null, '/cms/simple');
        $homepage->setBody('homepage');
        $homepage->setDefault('_template', 'AcmeDemoBundle::home.html.twig');
        $manager->persist($homepage);

        $page = new Page();
        $page->setTitle('contacte');
        $page->setLabel('contacte');
        $page->setBody('contacte.');
        $page->setDefault('_template', 'AcmeDemoBundle:Page:index.html.twig');
        $page->setPosition($homepage, 'contacte');
        $manager->persist($page);

        $page = new Page();
        $page->setTitle('biografia');
        $page->setLabel('biografia');
        $page->setBody('biografia.');
        $page->setDefault('_template', 'AcmeDemoBundle:Page:index.html.twig');
        $page->setPosition($homepage, 'biografia');
        $manager->persist($page);

        $workpage = new Page();
        $workpage->setTitle('treball recent');
        $workpage->setLabel('treball recent');
        $workpage->setBody('treball recent.');
        $workpage->setDefault('_template', 'AcmeDemoBundle::works.html.twig');
        $workpage->setPosition($homepage, 'treball-recent');
        $manager->persist($workpage);

        $page = new Page();
        $page->setTitle('mondrian');
        $page->setLabel('mondrian');
        $page->setBody('mondrian.');
        $page->setDefault('_template', 'AcmeDemoBundle::work.detail.html.twig');
        $page->setPosition($workpage, 'mondrian');
        $manager->persist($page);

        $page = new Page();
        $page->setTitle('castor');
        $page->setLabel('castor');
        $page->setBody('castor.');
        $page->setDefault('_template', 'AcmeDemoBundle::work.detail.html.twig');
        $page->setPosition($workpage, 'castor');
        $manager->persist($page);

        $page = new Page();
        $page->setTitle('welcome');
        $page->setLabel('welcome');
        $page->setBody('welcome.');
        $page->setDefault('_template', 'AcmeDemoBundle::work.detail.html.twig');
        $page->setPosition($workpage, 'welcome');
        $manager->persist($page);

        $page = new Page();
        $page->setTitle('duros a...');
        $page->setLabel('duros a...');
        $page->setBody('duros a...');
        $page->setDefault('_template', 'AcmeDemoBundle::work.detail.html.twig');
        $page->setPosition($workpage, 'duros-a');
        $manager->persist($page);

        $page = new Page();
        $page->setTitle('arxiu');
        $page->setLabel('arxiu');
        $page->setBody('arxiu.');
        $page->setDefault('_template', 'AcmeDemoBundle:Page:index.html.twig');
        $page->setPosition($homepage, 'arxiu');
        $manager->persist($page);

        $page = new Page();
        $page->setTitle('publicacions');
        $page->setLabel('publicacions');
        $page->setBody('publicacions.');
        $page->setDefault('_template', 'AcmeDemoBundle:Page:index.html.twig');
        $page->setPosition($homepage, 'publicacions');
        $manager->persist($page);

        // load the yaml file in src/Acme/DemoBundle/Resources/data/pages.yml
        //Fixtures::load(array(__DIR__.'/../../Resources/data/pages.yml'), $manager);

        // load the blocks
        //Fixtures::load(array(__DIR__.'/../../Resources/data/blocks.yml'), $manager);

        // save the changes
        $manager->flush();
    }
}
