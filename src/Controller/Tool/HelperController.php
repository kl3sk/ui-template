<?php

namespace Kl3sk\Controller\Tool;

class HelperController
{
    public function controller($shortName)
    {
        list($shortClass, $subDir, $shortMethod) = explode(':', $shortName, 3);

        return sprintf('Kl3sk\Controller\%s\%sController::%sAction', ucfirst($shortClass), ucfirst($subDir), $shortMethod);
    }
}
