<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\UserBundle\Admin\Entity\GroupAdmin;
use Sonata\UserBundle\Admin\Entity\UserAdmin;

class UtilisateurDroitsAdmin extends GroupAdmin
{
    protected $baseRouteName    = 'admin_utilisateur_droits';
    protected $baseRoutePattern = 'utilisateur_droits';

    protected $classnameLabel   = 'group';

}
