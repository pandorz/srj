<?php
namespace AppBundle\Service;

use AppBundle\Entity\Statistique;
use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\AdminInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\AdminBundle\Admin\Pool;


/**
 * Class StatistiqueBlockService
 * @package AppBundle\Service
 */
class StatistiqueBlockService extends AbstractBlockService
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var Pool
     */
    protected $pool;

    /**
     * @var AdminInterface
     */
    protected $admin;
    
    const FORMAT_DATE = 'Y-m-d';

    /**
     * TimeLineBlockService constructor.
     * @param null|string $name
     * @param \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $templating
     * @param EntityManager $entityManager
     * @param Pool $pool
     */
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
        return 'timeline';
    }


    /**
     * Calcule et affiche le block
     *
     * @param BlockContextInterface $blockContext
     * @param Response|null $response
     * @return Response
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();

        $this->admin            = $this->pool->getAdminByClass(Statistique::class);
        $repoStatistique        = $this->em->getRepository(Statistique::class);
        $tabMois                = [];
        $tabMoisAnneeDerniere   = [];
        for ($i=1; $i<=12; $i++) {
            $sum = $repoStatistique->sumByMonth($i);
            $tabMois[] = (is_null($sum)?0:$sum);

            $sum = $repoStatistique->sumByMonth($i, false);
            $tabMoisAnneeDerniere[] = (is_null($sum)?0:$sum);
        }

        return $this->renderResponse($blockContext->getTemplate(), array(
            'block'         => $blockContext->getBlock(),
            'settings'      => $settings,
            'tab_mois'      => $tabMois,
            'tab_mois_annee_derniere' => $tabMoisAnneeDerniere,
            'admin'         => $this->admin
        ), $response);
    }


    /**
     * @return array
     */
    public function getDefaultSettings()
    {
        return array();
    }

    /**
     * Liste des options necessaires dans le fichier yml
     *
     * @param OptionsResolver $resolver
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'icon'      => '',
            'color'     => '',
            'template'  => 'SonataAdminBundle:Block:block_stats.html.twig',
            'filters'   => '',
        ));
    }
}