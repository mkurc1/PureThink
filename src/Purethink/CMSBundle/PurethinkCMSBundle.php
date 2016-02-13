<?php

namespace Purethink\CMSBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PurethinkCMSBundle extends Bundle
{
    public function getParent()
    {
        return 'SonataUserBundle';
    }
}
