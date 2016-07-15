<?php 
namespace Brzez\AccessPolicyBundle\Tests\Mocks;

class Orange implements Edible
{

    public function isReadyToBeEaten()
    {
        return false;
    }
}
