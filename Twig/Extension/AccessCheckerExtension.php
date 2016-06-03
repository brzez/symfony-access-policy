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
            'can' => new \Twig_SimpleFunction('can', [$this, 'can']),
            'cannot' => new \Twig_SimpleFunction('cannot', [$this, 'cannot'])
        ];
    }

    public function can($intent, $object)
    {
        return call_user_func_array([$this->policyProvider, 'can'], func_get_args());
    }

    public function cannot($intent, $object)
    {        
        return call_user_func_array([$this->policyProvider, 'cannot'], func_get_args());
    }

    /**
    * {@inheritdoc}
    */
    public function getName() {
        return 'brzez_access_policy.twig_ext';
    }
}