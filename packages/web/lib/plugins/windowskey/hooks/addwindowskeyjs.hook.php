<?php
/**
 * Sets the javascript files up for this plugin.
 *
 * PHP version 5
 *
 * @category AddWindowsKeyJS
 * @package  FOGProject
 * @author   Tom Elliott <tommygunsster@gmail.com>
 * @license  http://opensource.org/licenses/gpl-3.0 GPLv3
 * @link     https://fogproject.org
 */
/**
 * Sets the javascript files up for this plugin.
 *
 * @category AddWindowsKeyJS
 * @package  FOGProject
 * @author   Tom Elliott <tommygunsster@gmail.com>
 * @license  http://opensource.org/licenses/gpl-3.0 GPLv3
 * @link     https://fogproject.org
 */
class AddWindowsKeyJS extends Hook
{
    /**
     * The name of this hook.
     *
     * @var string
     */
    public $name = 'AddWindowsKeyJS';
    /**
     * The description.
     *
     * @var string
     */
    public $description = 'Add Windows Key JS files.';
    /**
     * For posterity.
     *
     * @var bool
     */
    public $active = true;
    /**
     * What plugin this works against.
     *
     * @var string
     */
    public $node = 'windowskey';
    /**
     * Initialize object.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        if (!in_array($this->node, (array)self::$pluginsinstalled)) {
            return;
        }
        self::$HookManager->register(
            'PAGE_JS_FILES',
            [$this, 'injectJSFiles']
        );
    }
    /**
     * The files we need to inject.
     *
     * @param mixed $arguments The arguments to modify.
     *
     * @return void
     */
    public function injectJSFiles($arguments)
    {
        global $node;
        global $sub;
        $subset = $sub;
        if ($sub == 'membership') {
            $subset = 'edit';
        }
        $node = str_replace(
            '_',
            '-',
            $node
        );
        $subset = str_replace(
            '_',
            '-',
            $subset
        );
        switch ($node) {
        case 'windowskey':
            if (empty($subset)) {
                $filepaths = ["../lib/plugins/{$this->node}/js/fog.{$node}.js"];
            } else {
                $filepaths = [
                    "../lib/plugins/{$this->node}/js/fog.{$node}.{$subset}.js"
                ];
            }
            break;
        case 'image':
            if (empty($subset)) {
                $filepaths = [
                    "../lib/plugins/{$this->node}/js/fog.{$this->node}.{$node}.js"
                ];
            } else {
                $filepaths = [
                    "../lib/plugins/{$this->node}/js/"
                    . "fog.{$this->node}.{$node}.{$subset}.js"
                ];
            }
            break;
        default:
            return;
        }
        array_map(
            function (&$jsFilepath) use ($arguments) {
                array_push($arguments['files'], $jsFilepath);
                unset($jsFilepath);
            },
            (array)$filepaths
        );
    }
}
