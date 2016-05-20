<?php 
namespace Brzez\AccessPolicyBundle\Service\ContainerAware;

use Brzez\AccessPolicyBundle\Service\AccessPolicy;
use Brzez\AccessPolicyBundle\Service\AccessPolicyProvider;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ContainerAwareAccessPolicyProvider extends AccessPolicyProvider implements ContainerAwareInterface
{
    protected $container;

    function __construct()
    {
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}