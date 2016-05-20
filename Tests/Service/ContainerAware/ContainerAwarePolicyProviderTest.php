<?php 

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

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
        $container = static::$kernel->getContainer();
        $container->get('brzez_access_policy.access_policy_provider');
    }

    /** @test */
    public function it_loads_policies_from_config()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_injects_container_to_containeraware_policy()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_doesnt_break_on_non_containeraware_policies()
    {
        $this->markTestIncomplete();
    }
}