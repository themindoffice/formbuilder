<?php

namespace Modules\Addons;

use Modules\Addons\Formbuilder\Install\Installer;

class Formbuilder
{
    public function install()
    {
        require_once 'install/Installer.php';

        $installer = new Installer();
        $installer->run();
    }
}
