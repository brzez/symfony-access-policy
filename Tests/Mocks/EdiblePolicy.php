<?php
namespace Brzez\AccessPolicyBundle\Tests\Mocks;


use Brzez\AccessPolicyBundle\Service\AccessPolicyInterface;

class EdiblePolicy implements AccessPolicyInterface
{

    /**
     * @return string class
     */
    public function getPoliciedClass()
    {
        return Edible::class;
    }

    public function canEat(Edible $edible)
    {
        return $edible->isReadyToBeEaten();
    }
}