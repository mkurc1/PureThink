<?php

namespace Purethink\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PurethinkUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
