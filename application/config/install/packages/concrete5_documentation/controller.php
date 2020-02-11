<?php
namespace Application\StartingPointPackage\Concrete5Documentation;

use Concrete\Core\Application\Application;
use Concrete\Core\Backup\ContentImporter;
use Concrete\Core\Package\Routine\AttachModeInstallRoutine;
use Concrete\Core\Package\StartingPointInstallRoutine;
use Concrete\Core\Package\StartingPointPackage;

class Controller extends StartingPointPackage
{
    protected $pkgHandle = 'concrete5_documentation';

    public function getPackageName()
    {
        return t('concrete5.org Documentation');
    }

    public function getPackageDescription()
    {
        return 'Installs the concrete5.org documentation site.';
    }
    
}
