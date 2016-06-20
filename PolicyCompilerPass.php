<?php 
namespace Brzez\AccessPolicyBundle;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PolicyCompilerPass implements CompilerPassInterface
{
    const POLICY_PROVIDER_SERVICE = 'brzez_access_policy.access_policy_provider';
    const POLICY_SERVICE_TAG      = 'access_policy';

    public function process(ContainerBuilder $containerBuilder)
    {
        if(!$containerBuilder->has(self::POLICY_PROVIDER_SERVICE)){
            return;
        }

        $policyProvider = $containerBuilder->get(self::POLICY_PROVIDER_SERVICE);

        $policies = $containerBuilder->findTaggedServiceIds(self::POLICY_SERVICE_TAG);

        foreach($policies as $id => $tags){
            var_dump($id, $tags);
        }
    }
}
