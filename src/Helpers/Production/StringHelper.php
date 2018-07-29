<?php
namespace LaravelRocket\Foundation\Helpers\Production;

use LaravelRocket\Foundation\Helpers\StringHelperInterface;

class StringHelper implements StringHelperInterface
{
    public function randomString($length)
    {
        mt_rand();
        $characters = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
        $result     = '';
        for ($i = 0; $i < $length; ++$i) {
            $result .= $characters[mt_rand(0, count($characters) - 1)];
        }

        return $result;
    }

    public function randomReadableString($length)
    {
        mt_rand();
        $characters = str_split('ABCDEFGHJKLMNPQRSTUVWXYZ23456789');
        $result     = '';
        for ($i = 0; $i < $length; ++$i) {
            $result .= $characters[mt_rand(0, count($characters) - 1)];
        }
    }
}
