<?php

namespace Kl3sk\Controller\Tool;

class ToolController
{
    static public function d($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}
