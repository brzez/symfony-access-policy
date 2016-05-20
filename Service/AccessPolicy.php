<?php 
namespace Brzez\AccessPolicyBundle\Service;

abstract class AccessPolicy
{
    public function resolve($intent, array $args)
    {
        $methodName = $this->resolveIntentMethodName($intent);
        if(!method_exists($this, $methodName)){
            throw new \Exception("Resolving for `$intent` failed. Method [$methodName] does not exist");
        }
        return call_user_func_array([$this, $methodName], $args);
    }

    protected function resolveIntentMethodName($intent)
    {
        $camelCase = preg_replace_callback('/(?:^|-)(.?)/', function($match){
            return strtoupper($match[1]);
        }, $intent);
        
        $methodName = "can{$camelCase}";
        
        return $methodName;
    }
}