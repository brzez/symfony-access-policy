<?php 
namespace Brzez\AccessPolicyBundle\Tests\Service;

use Brzez\AccessPolicyBundle\Service\AccessPolicy;
use Brzez\AccessPolicyBundle\Service\AccessPolicyProvider;
use Brzez\AccessPolicyBundle\Service\AccessPolicyResolver;
use Brzez\AccessPolicyBundle\Tests\Mocks\Apple;
use Brzez\AccessPolicyBundle\Tests\Mocks\ApplePolicy;
use PHPUnit_Framework_TestCase;

class AccessPolicyProviderTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function throws_when_registering_multiple_policies_for_the_same_class()
    {
        $this->setExpectedException(\Exception::class);
        
        $resolver = $this->getMockBuilder(AccessPolicyResolver::class)->disableOriginalConstructor()->getMock();

        $provider = new AccessPolicyProvider($resolver);

        $provider->registerPolicy(new ApplePolicy);
        $provider->registerPolicy(new ApplePolicy);
    }

    /** @test */
    public function resolves_policy_for_specified_object()
    {
        $resolver = $this->getMockBuilder(AccessPolicyResolver::class)->disableOriginalConstructor()->getMock();
        $resolver->expects($this->once())->method('resolve')->with($this->isInstanceOf(ApplePolicy::class));

        $provider = new AccessPolicyProvider($resolver);
        $provider->registerPolicy(new ApplePolicy);
        
        $provider->can('view', new Apple);
    }

    /** @test */
    public function passes_multiple_args()
    {
        $apple = new Apple;
        $resolver = $this->getMockBuilder(AccessPolicyResolver::class)->disableOriginalConstructor()->getMock();
        $resolver->expects($this->exactly(2))->method('resolve')->with(
            $this->isInstanceOf(ApplePolicy::class),
            'view',
            [$apple, 1, 2, 3]
        );

        $provider = new AccessPolicyProvider($resolver);
        $provider->registerPolicy(new ApplePolicy);
        
        $provider->can('view', $apple, 1, 2, 3);
        $provider->cannot('view', $apple, 1, 2, 3);
    }
}
