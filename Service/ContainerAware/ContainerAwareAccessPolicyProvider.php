<?php 
namespace Brzez\AccessPolicyBundle\Service\ContainerAware;

use Brzez\AccessPolicyBundle\Service\AccessPolicy;
use Brzez\AccessPolicyBundle\Service\AccessPolicyProvider;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ContainerAwareAccessPolicyProvider extends AccessPolicyProvider implements ContainerAwareInterface
{
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function setPolicies($policies)
    {
        foreach ($policies as $policy) {
            extract($policy);
            $this->registerPolicy($class, new $policy);
        }
    }
}