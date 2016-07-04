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
        $class = $policy->getPoliciedClass();
        
        if(isset($this->policies[$class])){
            // todo: support multiple policies for the same type (?)
            throw new \Exception("Policy for [$class] already registered");
        }
        $this->policies[$class] = $policy;
    }

    public function can($intent, $object)
    {
        $policy = $this->resolvePolicy($object);
        $args   = array_slice(func_get_args(), 1);

        return $this->policyResolver->resolve($policy, $intent, $args);
    }

    public function cannot($intent, $object)
    {
        return ! call_user_func_array([$this, 'can'], func_get_args());
    }

    protected function resolvePolicy($object)
    {
        $class = get_class($object);
        if(!isset($this->policies[$class])){
            throw new \Exception("No policy registered for class [$class]");
        }
        return $this->policies[get_class($object)];
    }
}
