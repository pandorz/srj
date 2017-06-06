<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Rubrique;

/**
 * Class LoadRubrique
 * @package AppBundle\DataFixtures\ORM
 */
class LoadRubrique extends AbstractFixture  implements OrderedFixtureInterface
{
    /**
     * Charge les actions
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Liste des rubriques à ajouter
        $liste = array(
                        array
                        (
                            'type' => 'association',
                            'nom' => 'Historique / Création',
                            'route' => '',
							'ordre' => 1,
							'enfants' => array()
                        ),
                        array
                        (
                            'type' => 'association',
                            'nom' => 'Le bureau',
                            'route' => '',
							'ordre' => 2,
							'enfants' => array()
                        ),
						array
                        (
                            'type' => 'association',
                            'nom' => 'Nos partenaires',
                            'route' => '',
							'ordre' => 3,
							'enfants' => array()
                        ),
						array
                        (
                            'type' => 'association',
                            'nom' => 'Devenir Membre',
                            'route' => '',
							'ordre' => 4,
							'enfants' => array(
												array
												(
													'nom' => 'Informations',
													'route' => '',
													'ordre' => 1,
												),
												array
												(
													'nom' => 'Formulaire d\'inscription',
													'route' => 'formulaire_inscription',
													'ordre' => 2,
												),
											)
                        ),
						array
                        (
                            'type' => 'activites',
                            'nom' => 'Les cours',
                            'route' => '',
							'ordre' => 1,
							'enfants' => array(
												array
												(
													'nom' => 'Japonais',
													'route' => '',
													'ordre' => 1,
												),
												array
												(
													'nom' => 'Calligraphie',
													'route' => '',
													'ordre' => 2,
												),
												array
												(
													'nom' => 'Cérémonie du thé',
													'route' => '',
													'ordre' => 3,
												),
											)
                        ),
						array
                        (
                            'type' => 'activites',
                            'nom' => 'Ateliers et sorties',
                            'route' => '',
							'ordre' => 2,
							'enfants' => array()
                        ),
                      );

        foreach ($liste as $info) 
        {
            $rubrique   = $manager
                        ->getRepository('AppBundle\Entity\Rubrique')
                        ->findOneByNom($info['nom']);
						
			$type       = $manager
                        ->getRepository('AppBundle\Entity\TypeRubrique')
                        ->findOneByNom($info['type']);
						
            if(empty($rubrique) && !empty($type))
            {
                // On crée la rubrique
                $rubrique = new Rubrique();
                $rubrique->setNom($info['nom']);
                $rubrique->setType($type);
                $rubrique->setOrdre($info['ordre']);
				if(!empty($info['route']))
					$rubrique->setRoute($info['route']);
				
				$tab_enfant = array();
				if(!empty($info['enfants']))
				{
					foreach($info['enfants'] as $enfant)
					{
						$rubrique_enfant = new Rubrique();
						$rubrique_enfant->setNom($enfant['nom']);
						$rubrique_enfant->setType($type);
						$rubrique_enfant->setOrdre($enfant['ordre']);
						if(!empty($enfant['route']))
							$rubrique_enfant->setRoute($enfant['route']);
						
						$tab_enfant[] = $rubrique_enfant;	
						$manager->persist($rubrique_enfant);
					}
				}
				foreach($tab_enfant as $rubrique_enfant)
					$rubrique->addEnfant($rubrique_enfant);
                // On la persiste
                $manager->persist($rubrique);
				
					
            }
        }

        // On déclenche l'enregistrement de toutes les difficulte
        $manager->flush();
    }

    /**
     * Ordre d'execution
     *
     * @return int
     */
    public function getOrder()
    {
        return 2; 
    }
}

