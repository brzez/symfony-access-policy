<?php 
namespace Brzez\AccessPolicyBundle\Tests\Mocks;

use Brzez\AccessPolicyBundle\Service\AccessPolicyInterface;
use Brzez\AccessPolicyBundle\Tests\Mocks\Orange;

class OrangePolicy implements AccessPolicyInterface
{
    public function getPoliciedClass()
    {
        return Orange::class;
    }

    public function canDoSomething()
    {
        return true;
    }
}
