<?php 
namespace Brzez\AccessPolicyBundle\Tests\Service;

use Brzez\AccessPolicyBundle\Service\AccessPolicy;
use Brzez\AccessPolicyBundle\Tests\Service\Mocks\Banana;
use Brzez\AccessPolicyBundle\Tests\Service\Mocks\BananaPolicy;
use PHPUnit_Framework_TestCase;

class AccessPolicyTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_resolves_intent_names_to_proper_methods()
    {
        $policy = $this->getMockBuilder(BananaPolicy::class)->setMethods(['canEatThisBanana'])->getMock();
        $policy->expects($this->once())->method('canEatThisBanana')->willReturn(true);
        $this->assertTrue($policy->resolve('eat-this-banana', [new Banana]));
    }

    /** @test */
    public function it_throws_when_method_cannot_be_resolved()
    {
        $this->setExpectedException(\Exception::class);

        $policy = new BananaPolicy();

        $policy->resolve('non-existent-policy', [new Banana]);
    }

    /** @test */
    public function it_passes_multiple_args_to_the_intent_method()
    {
        $policy = $this->getMockBuilder(BananaPolicy::class)->setMethods(['canEditSomething'])->getMock();

        $policy
            ->expects($this->once())->method('canEditSomething')
            ->with(
                $this->isInstanceOf(Banana::class),
                $this->equalTo('something'),
                $this->equalTo(1),
                $this->equalTo(2)
            )
            ->willReturn(true);

        $this->assertTrue($policy->resolve('edit-something', [new Banana, 'something', 1, 2]));
    }
}