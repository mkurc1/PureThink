<?php

namespace My\CommentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MyCommentBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSCommentBundle';
    }
}
