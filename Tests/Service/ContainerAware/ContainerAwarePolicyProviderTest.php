<?php 

use Brzez\AccessPolicyBundle\Service\AccessPolicy;
use Brzez\AccessPolicyBundle\Service\ContainerAware\ContainerAwareAccessPolicy;
use Brzez\AccessPolicyBundle\Service\ContainerAware\ContainerAwareAccessPolicyProvider;
use Brzez\AccessPolicyBundle\Tests\Service\Mocks\Apple;
use Brzez\AccessPolicyBundle\Tests\Service\Mocks\AppleContainerAwarePolicy;
use Brzez\AccessPolicyBundle\Tests\Service\Mocks\BananaPolicy;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ContainerAwarePolicyProviderTest extends KernelTestCase
{
    public function setUp()
    {
        parent::setUp();
        static::bootKernel([]);    
    }


    /** @test */
    public function it_is_registered_as_a_service()
    {
        $provider = $this->getPolicyProvider();

        $this->assertInstanceOf(ContainerAwareAccessPolicyProvider::class, $provider);
    }

    /** @test */
    public function it_injects_container_to_containeraware_policy()
    {
        $provider = $this->getPolicyProvider();

        $policyMock = $this->getMock(ContainerAwareAccessPolicy::class);
        $policyMock->expects($this->once())->method('setContainer')->with(
            $this->isInstanceOf(ContainerInterface::class)
        );

        $provider->registerPolicy(Apple::class, $policyMock);
    }

    /** @test */
    public function it_doesnt_break_on_non_containeraware_policies()
    {
        $provider = $this->getPolicyProvider();

        $provider->registerPolicy(Banana::class, new BananaPolicy);
    }


    public function getContainer()
    {
        return static::$kernel->getContainer();
    }

    /**
     * @return ContainerAwareAccessPolicyProvider
     */
    public function getPolicyProvider()
    {
        return $this->getContainer()->get('brzez_access_policy.access_policy_provider');
    }

}