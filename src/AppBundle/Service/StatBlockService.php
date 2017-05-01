<?php
namespace AppBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Sonata\BlockBundle\Block\BlockContextInterface;

use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\AdminBundle\Admin\Pool;


class StatBlockService extends AbstractBlockService
{

    /**
     * @var EntityManager
     */
    protected $em;

    protected $pool;

    protected $admin;

    public function __construct($name, $templating, EntityManager $entityManager, Pool $pool)
    {
        parent::__construct($name, $templating);
        $this->em   = $entityManager;
        $this->pool = $pool;
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'statistique';
    }


    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();

        $pager = $this->getStats($settings['entity']);

        return $this->renderResponse($blockContext->getTemplate(), array(
            'block'     => $blockContext->getBlock(),
            'settings'  => $settings,
            'pager'     => $pager,
            'admin'     => $this->admin
        ), $response);
    }


    public function getDefaultSettings()
    {
        return array();
    }

    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'text'      => '',
            'icon'      => '',
            'color'     => '',
            'template'  => 'SonataAdminBundle:Block:block_stats.html.twig',
            'filters'   => '',
            'entity'    => null
        ));
    }

    private function getStats($entityName)
    {
        if (!class_exists($entityName)) {
            throw new \Exception('Block stats service, entity doesn\'t exists', Response::HTTP_FAILED_DEPENDENCY);
        }
        $this->admin    = $this->pool->getAdminByClass($entityName);
        $allObjects     = $this->em->getRepository($entityName)->findAll();
        return new ArrayCollection($allObjects);
    }
}