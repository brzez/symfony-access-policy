<?php 
namespace Brzez\AccessPolicyBundle\Tests\Service;

use Brzez\AccessPolicyBundle\Service\AccessPolicy;
use Brzez\AccessPolicyBundle\Service\AccessPolicyProvider;
use Brzez\AccessPolicyBundle\Service\AccessPolicyResolver;
use Brzez\AccessPolicyBundle\Tests\Mocks\AnotherApplePolicy;
use Brzez\AccessPolicyBundle\Tests\Mocks\Apple;
use Brzez\AccessPolicyBundle\Tests\Mocks\ApplePolicy;
use Brzez\AccessPolicyBundle\Tests\Mocks\Orange;
use PHPUnit_Framework_TestCase;

class AccessPolicyProviderTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function supports_multiple_policies()
    {
        $resolver = $this->getMockBuilder(AccessPolicyResolver::class)->disableOriginalConstructor()->getMock();

        $provider = new AccessPolicyProvider($resolver);

        $provider->registerPolicy(new ApplePolicy);
        $provider->registerPolicy(new AnotherApplePolicy);

        $apple = new Apple;

        $this->assertTrue($provider->can('do-thing', $apple));
        $this->assertFalse($provider->can('do-other-thing', $apple));
    }

    /** @test */
    public function resolves_policy_for_specified_object()
    {
        $applePolicy = new ApplePolicy;

        $resolver = $this->getMockBuilder(AccessPolicyResolver::class)->disableOriginalConstructor()->getMock();
        $resolver->expects($this->once())->method('resolve')->with([$applePolicy]);

        $provider = new AccessPolicyProvider($resolver);
        $provider->registerPolicy($applePolicy);
        
        $provider->can('view', new Apple);
    }

    /** @test */
    public function passes_multiple_args()
    {
        $apple       = new Apple;
        $applePolicy = new ApplePolicy;

        $resolver = $this->getMockBuilder(AccessPolicyResolver::class)->disableOriginalConstructor()->getMock();
        $resolver->expects($this->exactly(2))->method('resolve')->with(
            [$applePolicy],
            'view',
            [$apple, 1, 2, 3]
        );

        $provider = new AccessPolicyProvider($resolver);
        $provider->registerPolicy($applePolicy);
        
        $provider->can('view', $apple, 1, 2, 3);
        $provider->cannot('view', $apple, 1, 2, 3);
    }

    /** @test */
    public function throws_when_class_is_not_policied()
    {
        $this->setExpectedException(\Exception::class);

        $resolver = $this->getMockBuilder(AccessPolicyResolver::class)->disableOriginalConstructor()->getMock();

        $provider = new AccessPolicyProvider($resolver);
        $provider->registerPolicy(new ApplePolicy);
        
        $provider->can('view', new Orange, 1, 2, 3);
    }
}
