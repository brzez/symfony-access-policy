<?php

namespace Brzez\AccessPolicyBundle\Tests\Service\Mocks;

use Brzez\AccessPolicyBundle\Service\AccessPolicy;
use Brzez\AccessPolicyBundle\Tests\Service\Mocks\Banana;

class BananaPolicy extends AccessPolicy
{
    public function canEatThisBanana(Banana $banana)
    {
        return true;
    }

    public function canEditSomething(Banana $banana)
    {
        return true;
    }
}