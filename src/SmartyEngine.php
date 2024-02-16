<?php

namespace Fignon\Extra;

use Fignon\Extra\ViewEngine;

/**
 * This is just a bridge between this framework and Smarty Php Engine
 *
 * For more customization, @see https://www.smarty.net/
 *
 * When using this engine, you have to give the template with the extension
 *
 * E.g: 'example' for 'example.tpl'
 *
 * You need to configure Fignon by providing additional options like:
 *
 * $options = [
 *    'compileDir' => 'path/to/compile/dir',
 *    'configDir' => 'path/to/config/dir'
 * ];
 *
 * Smarty needs a config dir and a compile dir to work
 */
class SmartyEngine implements ViewEngine
{
    protected $loader;

    public function init(string $templatePath = null, string $templateCachedPath = null, array $options = []): SmartyEngine
    {
        if (null === $templateCachedPath || null === $templatePath) {
            throw new \Fignon\Error\TunnelError('Template path or cached path is not set');
        }

        if (!isset($options['compileDir']) || !isset($options['configDir'])) {
            throw new \Fignon\Error\TunnelError('Smarty need a config dir and a compile dir');
        }

        $smarty = new \Smarty();
        $smarty->setTemplateDir($templatePath);
        $smarty->setConfigDir($options['configDir']);
        $smarty->setCompileDir($options['compileDir']);
        $smarty->setCacheDir($templateCachedPath);

        $this->loader = $smarty;

        return $this;
    }

    public function render(string $viewPath = '', $locals = [], array $options = []): string
    {

        if (null === $this->loader) {
            throw new \Fignon\Error\TunnelError('Template path or cached path is not set');
        }

        if (!\is_array($locals)) {
            throw new \Fignon\Error\TunnelError('Locals must be an array');
        }

        if ('' === $viewPath) {
            throw new \Fignon\Error\TunnelError('View path is empty');
        }

        // Assign locals to the template
        foreach ($locals as $key => $value) {
            $this->loader->assign($key, $value);
        }

        // Compile the template and get the string
        return  $this->loader->fetch($viewPath);
    }
}
