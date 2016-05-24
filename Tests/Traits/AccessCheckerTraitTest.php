<?php 

use Brzez\AccessPolicyBundle\Service\ContainerAware\ContainerAwareAccessPolicyProvider;
use Brzez\AccessPolicyBundle\Tests\Service\Mocks\Apple;
use Brzez\AccessPolicyBundle\Tests\Traits\AccessCheckerTraitImpl;

class AccessCheckerTraitTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_passes_multiargs_to_the_provider()
    {
        $policyProviderMock = $this->getMock(ContainerAwareAccessPolicyProvider::class);

        $policyProviderMock->expects($this->once())->method('can')
            ->with('intent', $this->isInstanceOf(Apple::class), 'arg 1', 'arg 2')
        ;
        $policyProviderMock->expects($this->once())->method('cannot')
            ->with('intent', $this->isInstanceOf(Apple::class), 'arg 1', 'arg 2')
        ;

        $traitImpl = new AccessCheckerTraitImpl($policyProviderMock);

        $traitImpl->can('intent', new Apple, 'arg 1', 'arg 2');
        $traitImpl->cannot('intent', new Apple, 'arg 1', 'arg 2');
    }
}