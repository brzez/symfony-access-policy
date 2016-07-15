<?php 
namespace Brzez\AccessPolicyBundle\Tests\Mocks;

use Brzez\AccessPolicyBundle\Service\AccessPolicyInterface;
use Brzez\AccessPolicyBundle\Tests\Mocks\Apple;

class AnotherApplePolicy implements AccessPolicyInterface
{
    public function getPoliciedClass()
    {
        return Apple::class;
    }

    public function canDoOtherThing()
    {
        return false;
    }
}
