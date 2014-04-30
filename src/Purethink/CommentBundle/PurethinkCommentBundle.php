<?php

namespace Purethink\CommentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PurethinkCommentBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSCommentBundle';
    }
}
