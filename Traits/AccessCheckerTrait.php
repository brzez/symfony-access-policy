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
        /** @var \Brzez\AccessPolicyBundle\Service\ContainerAware\ContainerAwareAccessPolicyProvider */
        return $this->getPolicyProvider()->can($intent, $object);
    }

    public function cannot($intent, $object)
    {
        /** @var \Brzez\AccessPolicyBundle\Service\ContainerAware\ContainerAwareAccessPolicyProvider */
        return $this->getPolicyProvider()->cannot($intent, $object);
    }
}