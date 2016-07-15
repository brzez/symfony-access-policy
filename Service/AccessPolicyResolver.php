<?php 
namespace Brzez\AccessPolicyBundle\Service;

class AccessPolicyResolver
{
    public function resolve($policies, $intent, $args)
    {
        $methodName = $this->resolveIntentMethodName($intent);

        foreach ($policies as $policy) {
            if(!method_exists($policy, $methodName)){
                continue;
            }
            return call_user_func_array([$policy, $methodName], $args);
        }

        throw new \Exception("Resolving for `$intent` failed. Method [$methodName] not found.");
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
