<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\UserBundle\Admin\Entity\UserAdmin;

class UtilisateurAdmin extends UserAdmin
{
    protected $baseRouteName    = 'admin_utilisateur';
    protected $baseRoutePattern = 'utilisateur';



}
