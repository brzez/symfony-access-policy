<?php 
namespace Brzez\AccessPolicyBundle\Tests\Service;

use AppBundle\TestPolicy;
use Brzez\AccessPolicyBundle\Service\AccessPolicyResolver;
use Brzez\AccessPolicyBundle\Tests\Mocks\Apple;
use PHPUnit_Framework_TestCase;

class AccessPolicyResolverTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function throws_when_policy_method_does_not_exist()
    {
        $this->setExpectedException(\Exception::class);

        $resolver = new AccessPolicyResolver();

        $resolver->resolve(new TestPolicy, 'non-existent-intent', [new Apple]);
    }

    /**
     * @test
     */
    public function translates_intent_from_kebab_case_to_camelCase()
    {
        $resolver = new AccessPolicyResolver;

        $policyMock = $this->getMock(TestPolicy::class);

        $policyMock->expects($this->once())
            ->method('canDoSomething');

        $resolver->resolve($policyMock, 'do-something', [new Apple]);
    }

    /**
     * @test
     */
    public function passes_multiple_args_to_intent_method()
    {
        $resolver = new AccessPolicyResolver;

        $policyMock = $this->getMock(TestPolicy::class);

        $apple = new Apple;

        $policyMock->expects($this->once())
            ->method('canDoSomething')
            ->with($apple, 1, 2, 3);

        $resolver->resolve($policyMock, 'do-something', [$apple, 1, 2, 3]);
    }
}
