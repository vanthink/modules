<?php

namespace Vanthink\Modules\Helper;

use Vanthink\Modules\Modules;
use Illuminate\Http\Request;

class Helper
{
    public function getVersion(Request $request, Modules $modules, $module_name)
    {
        $version  = $request->header('version');
        $versions = $modules->get($module_name.'::version');
        if (!in_array($version, $versions)) {
            $r_versions = array_reverse($versions);
            if (!$version) {
                $version = $r_versions[0];
            } else {
                for ($i = 0; $i < count($r_versions); $i++) {
                    if (version_compare($version, $r_versions[$i], '<')) {
                        continue;
                    }
                    $version = $r_versions[$i];
                    break;
                }
                if (!in_array($version, $versions)) {
                    $version = $versions[0];
                }
            }
        }
        $version = str_replace('.', '_', $version);
        return $version;
    }
    
    public function getAvailableVersion(Request $request, Modules $modules, $router, $module_name, $namespase)
    {
        $version  = $request->header('version');
        $versions = $modules->get($module_name.'::version');
        
        $r_versions = array_reverse($versions);
        if (!$version) {
            $version = $r_versions[0];
        }
        for ($i = 0; $i < count($r_versions); $i++) {
            if (version_compare($version, $r_versions[$i], '<')) {
                continue;
            }
            $version = $r_versions[$i];
            if (!$this->checkActionExists($request, $router, $namespase.'\v'.str_replace('.', '_', $version))) {
                continue;
            }
            break;
        }
        if (!in_array($version, $versions)) {
            $version = $versions[0];
        }
        $version = str_replace('.', '_', $version);
        return $version;
    }
    
    public function checkActionExists($request, $router, $namespace)
    {
        try {
            $action_name = $router->getRoutes()->match($request)->getActionName();
        } catch (\Exception $e) {
            return false;
        }
        list($controller, $action) = explode('@', $action_name);
        return method_exists($namespace.'\\'.$controller, $action);
    }
}
