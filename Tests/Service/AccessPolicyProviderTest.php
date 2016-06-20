<?php 
namespace Brzez\AccessPolicyBundle\Tests\Service;

use Brzez\AccessPolicyBundle\Service\AccessPolicy;
use Brzez\AccessPolicyBundle\Service\AccessPolicyProvider;
use PHPUnit_Framework_TestCase;

class AccessPolicyProviderTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_runs_methods_from_proper_policy()
    {
        $service = $this->createAccessPolicyProvider();

        $policy = $this->getMock(AccessPolicy::class);
        $policy->expects($this->once())->method('resolve')->willReturn(true);
        $service->registerPolicy(Apple::class, $policy);

        $policy = $this->getMock(AccessPolicy::class);
        $policy->expects($this->once())->method('resolve')->willReturn(true);
        $service->registerPolicy(Banana::class, $policy);  

        $this->assertTrue($service->can('edit', new Apple()));
        $this->assertFalse($service->cannot('edit', new Banana()));
    }

    /** @test */
    public function it_throws_when_two_policies_register_for_the_same_class()
    {
        $this->setExpectedException(\Exception::class);
        
        $service = $this->createAccessPolicyProvider();

        $service->registerPolicy(Apple::class, $this->getMock(AccessPolicy::class));
        $service->registerPolicy(Apple::class, $this->getMock(AccessPolicy::class));
    }

    /** @test */
    public function it_throws_when_policy_is_not_registered()
    {
        $this->setExpectedException(\Exception::class);
        
        $service = $this->createAccessPolicyProvider();

        $service->can('non-existent-intent', new Apple());
    }

    /** @test */
    public function it_passes_multiple_args_to_the_provider()
    {
        $provider = $this->createAccessPolicyProvider();
        $object = new Banana;

        $policyMock = $this->getMock(AccessPolicy::class);

        $policyMock->expects($this->exactly(2))->method('resolve')->with(
            'eat-this-banana',
            [$object, 'arg 1', 'arg 2']
        );

        $provider->registerPolicy(Banana::class, $policyMock);

        $provider->can('eat-this-banana', $object, 'arg 1', 'arg 2');
        $provider->cannot('eat-this-banana', $object, 'arg 1', 'arg 2');
    }

    private function createAccessPolicyProvider()
    {
        return new AccessPolicyProvider;
    }
}
