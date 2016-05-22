<?php 

namespace Brzez\AccessPolicyBundle\Twig\Extension;

use Brzez\AccessPolicyBundle\Service\ContainerAware\ContainerAwareAccessPolicyProvider;

class AccessCheckerExtension extends \Twig_Extension
{
    /** @var ContainerAwareAccessPolicyProvider */
    protected $policyProvider;

    function __construct(ContainerAwareAccessPolicyProvider $policyProvider)
    {
        $this->policyProvider = $policyProvider;    
    }
    /**
    * {@inheritdoc}
    */
    public function getFunctions() {
        return [
            'can' => new \Twig_Function_Method($this, 'can'),
            'cannot' => new \Twig_Function_Method($this, 'cannot')
        ];
    }

    public function can($intent, $object)
    {
        return $this->policyProvider->can($intent, $object);
    }

    public function cannot($intent, $object)
    {
        return $this->policyProvider->cannot($intent, $object);
    }

    /**
    * {@inheritdoc}
    */
    public function getName() {
        return 'brzez_access_policy.twig_ext';
    }
}