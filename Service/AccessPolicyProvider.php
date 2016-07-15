<?php 
namespace Brzez\AccessPolicyBundle\Service;

use Brzez\AccessPolicyBundle\Service\AccessPolicyInterface;
use Brzez\AccessPolicyBundle\Service\AccessPolicyResolver;

class AccessPolicyProvider
{
    protected $policyResolver;
    protected $policies = [];

    function __construct(AccessPolicyResolver $policyResolver)
    {
        $this->policyResolver = $policyResolver;
    }

    public function registerPolicy(AccessPolicyInterface $policy)
    {
        $this->policies[] = $policy;
        return $this;
    }

    public function can($intent, $object)
    {
        $policies = $this->filterPolicies($object);
        $args     = array_slice(func_get_args(), 1);

        return $this->policyResolver->resolve($policies, $intent, $args);
    }

    public function cannot($intent, $object)
    {
        return ! call_user_func_array([$this, 'can'], func_get_args());
    }

    protected function filterPolicies($object)
    {
        $filtered = array_filter($this->policies, function(AccessPolicyInterface $policy) use ($object){
            $className = $policy->getPoliciedClass();
            return is_object($object) && is_a($object, $className);
        });

        if(!count($filtered)){
            $class = get_class($object);
            throw new \Exception("No policy registered for class [$class]");
        }
        return $filtered;
    }
}
