<?php

namespace Utility\ClassBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Utility\ClassBundle\Entity\TypeRubrique;

/**
 * Class LoadTypeRubrique
 * @package Utility\ClassBundle\DataFixtures\ORM
 */
class LoadTypeRubrique extends AbstractFixture  implements OrderedFixtureInterface
{
    /**
     * Charge les actions
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Liste des types à ajouter
        $liste = array(
                        'association' => "L'Association",
                        'activites' => "Nos activités",
                      );

        foreach ($liste as $nom=>$libelle) 
        {
            $type = $manager
                        ->getRepository('Utility\ClassBundle\Entity\TypeRubrique')
                        ->findOneByNom($nom);
            if(empty($type))
            {
                // On crée le type
                $type = new TypeRubrique();
                $type->setLibelle($libelle);
				$type->setNom($nom);

                // On la persiste
                $manager->persist($type);
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
        return 1; 
    }
}

