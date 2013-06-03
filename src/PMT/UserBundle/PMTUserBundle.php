<?php

namespace PMT\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PMTUserBundle extends Bundle
{
    /**
     * We want to be able to override things in the FOSUserBundle.
     *
     * @return string
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
