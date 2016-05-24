<?php 
namespace Brzez\AccessPolicyBundle\Traits;


trait AccessCheckerTrait
{
    /**
     * @return \Brzez\AccessPolicyBundle\Service\ContainerAware\ContainerAwareAccessPolicyProvider
     */
    public function getPolicyProvider()
    {
        return $this->get('brzez_access_policy.access_policy_provider');
    }

    public function can($intent, $object)
    {
        return call_user_func_array([$this->getPolicyProvider(), 'can'], func_get_args());
    }

    public function cannot($intent, $object)
    {
        return call_user_func_array([$this->getPolicyProvider(), 'cannot'], func_get_args());
    }
}