<?php
namespace AppBundle\Service;

use AppBundle\Entity\Blog;
use AppBundle\Entity\Kouryukai;
use Doctrine\ORM\EntityManager;

use AppBundle\Entity\Actualite;
use AppBundle\Entity\Evenement;
use AppBundle\Entity\Atelier;
use AppBundle\Entity\Sortie;
use Sonata\AdminBundle\Admin\AdminInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Sonata\BlockBundle\Block\BlockContextInterface;

use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\AdminBundle\Admin\Pool;

/**
 * Class TimeLineBlockService
 * @package AppBundle\Service
 */
class TimeLineBlockService extends AbstractBlockService
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

        $this->admin    = $this->pool->getAdminByClass(Actualite::class);
        $repoActualite  = $this->em->getRepository(Actualite::class);
        $actualites     = $repoActualite->findAllValidOverOneMonth(true);
        
        $repoEvenement  = $this->em->getRepository(Evenement::class);
        $evenements     = $repoEvenement->findAllValidOverOneMonth(true);
        
        $repoAtelier    = $this->em->getRepository(Atelier::class);
        $ateliers       = $repoAtelier->findAllValidOverOneMonth(true);
        
        $repoSortie     = $this->em->getRepository(Sortie::class);
        $sorties        = $repoSortie->findAllValidOverOneMonth(true);

        $repoKouryukai  = $this->em->getRepository(Kouryukai::class);
        $kouryukai      = $repoKouryukai->findAllValidOverOneMonth(true);

        $repoBlog       = $this->em->getRepository(Blog::class);
        $blogs          = $repoBlog->findAllValidOverOneMonth(true);

        
        $tab = array();


        foreach ($evenements as $evenement) {
            if (!empty($evenement->getDatePublication())) {
                $temp = [
                    'icon' => 'fa-calendar',
                    'objet' => $evenement,
                    'bg' => 'bg-aqua',
                    'trans' => 'evenement.add_edit.to_string'
                ];

                $tab[$evenement->getDatePublication()->format(self::FORMAT_DATE)][] = $temp;
            }
        }
        
        foreach ($actualites as $actualite) {
            if (!empty($actualite->getDatePublication())) {
                $temp = [
                    'icon' => 'fa-newspaper-o',
                    'objet' => $actualite,
                    'bg' => 'bg-purple',
                    'trans' => 'actualite.add_edit.to_string'
                ];

                $tab[$actualite->getDatePublication()->format(self::FORMAT_DATE)][] = $temp;
            }
        }
        
        foreach ($ateliers as $atelier) {
            if (!empty($atelier->getDatePublication())) {
                $temp = [
                    'icon' => 'fa-pencil',
                    'objet' => $atelier,
                    'bg' => 'bg-maroon',
                    'trans' => 'atelier.add_edit.to_string'
                ];

                $tab[$atelier->getDatePublication()->format(self::FORMAT_DATE)][] = $temp;
            }
        }
        
        foreach ($sorties as $sortie) {
            if (!empty($sortie->getDatePublication())) {
                $temp = [
                    'icon' => 'fa-car',
                    'objet' => $sortie,
                    'bg' => 'bg-yellow',
                    'trans' => 'sortie.add_edit.to_string'
                ];

                $tab[$sortie->getDatePublication()->format(self::FORMAT_DATE)][] = $temp;
            }
        }

        foreach ($kouryukai as $k) {
            if (!empty($k->getDatePublication())) {
                $temp = [
                    'icon' => 'fa-clock-o',
                    'objet' => $k,
                    'bg' => 'bg-olive',
                    'trans' => 'kouryukai.add_edit.to_string'
                ];

                $tab[$k->getDatePublication()->format(self::FORMAT_DATE)][] = $temp;
            }
        }

        foreach ($blogs as $blog) {
            if (!empty($blog->getDatePublication())) {
                $temp = [
                    'icon' => 'fa-rss',
                    'objet' => $blog,
                    'bg' => 'bg-fuchsia',
                    'trans' => 'blog.add_edit.to_string'
                ];

                $tab[$blog->getDatePublication()->format(self::FORMAT_DATE)][] = $temp;
            }
        }
        krsort($tab);
        return $this->renderResponse($blockContext->getTemplate(), array(
            'block'         => $blockContext->getBlock(),
            'settings'      => $settings,
            'liste_dates'   => $tab,
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