<?php
namespace Purethink\CoreBundle\Utility;

class RemoveDirectory
{
    public static function rmDir($dir)
    {
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file)) {
                self::rmdir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dir);
    }
}