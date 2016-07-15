<?php 
namespace Brzez\AccessPolicyBundle\Tests\Mocks;

class Apple implements Edible
{

    public function isReadyToBeEaten()
    {
        return true;
    }
}
