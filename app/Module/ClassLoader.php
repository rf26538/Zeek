<?php

namespace App\Module;

class ClassLoader
{
    /**
     * @var PluginManager
     */
    protected $pluginManager;

    /**
     * ClassLoader constructor.
     */
    public function __construct(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }

    /**
     * Loads the given class or interface.
     *
     * @return bool|null
     */
    public function loadClass($class)
    {
        if (isset($this->pluginManager->getClassMap()[$class])) {
            \Composer\Autoload\includeFile($this->pluginManager->getClassMap()[$class]);

            return true;
        }
    }
}
