<?php 
namespace Brzez\AccessPolicyBundle;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class PolicyCompilerPass implements CompilerPassInterface
{
    const POLICY_PROVIDER_SERVICE = 'brzez_access_policy.access_policy_provider';
    const POLICY_SERVICE_TAG      = 'access_policy';

    public function process(ContainerBuilder $containerBuilder)
    {
        if(!$containerBuilder->has(self::POLICY_PROVIDER_SERVICE)){
            return;
        }

        $providerDefinition = $containerBuilder->findDefinition(self::POLICY_PROVIDER_SERVICE);

        $policies = $containerBuilder->findTaggedServiceIds(self::POLICY_SERVICE_TAG);

        foreach($policies as $id => $tags){
            $this->registerPolicy($providerDefinition, $id, $tags);
        }
    }

    public function registerPolicy(Definition $providerDefinition, $id, $tags)
    {
        foreach ($tags as $tag) {
            $providerDefinition->addMethodCall('registerPolicy', [
                new Reference($id)
            ]);
        }
    }
}
