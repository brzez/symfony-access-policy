<?php 

namespace Brzez\AccessPolicyBundle\Tests\Twig\Extension;

use Brzez\AccessPolicyBundle\Service\ContainerAware\ContainerAwareAccessPolicyProvider;
use Brzez\AccessPolicyBundle\Tests\Service\Mocks\Apple;
use Brzez\AccessPolicyBundle\Twig\Extension\AccessCheckerExtension;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class AccessCheckerExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_passes_multiple_args_to_the_policyprovider()
    {
        $providerMock = $this->getMock(ContainerAwareAccessPolicyProvider::class);

        $providerMock->expects($this->once())->method('can')
            ->with($this->isInstanceOf(Apple::class), 'arg 1', 'arg 2')
        ;
        $providerMock->expects($this->once())->method('cannot')
            ->with($this->isInstanceOf(Apple::class), 'arg 1', 'arg 2')
        ;

        $ext = new AccessCheckerExtension($providerMock);

        $ext->can('intent', new Apple, 'arg 1', 'arg 2');
        $ext->cannot('intent', new Apple, 'arg 1', 'arg 2');
    }
}