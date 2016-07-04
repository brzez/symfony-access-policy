<?php 
namespace Brzez\AccessPolicyBundle\Service;

class AccessPolicyResolver
{
    public function resolve($policy, $intent, $args)
    {
        $methodName = $this->resolveIntentMethodName($intent);

        $this->validateMethodExists($policy, $intent, $methodName);
        return call_user_func_array([$policy, $methodName], $args);
    }

    public function validateMethodExists($policy, $intent, $methodName)
    {
        if(method_exists($policy, $methodName)){
            return;
        }

        $class = get_class($policy);
        // @todo: custom exception
        throw new \Exception("Resolving for `$intent` failed. Method [$methodName] does not exist on $class");
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
