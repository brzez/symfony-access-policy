<?php
namespace Brzez\AccessPolicyBundle\Tests\Traits;

use Brzez\AccessPolicyBundle\Traits\AccessCheckerTrait;

class AccessCheckerTraitImpl
{
    use AccessCheckerTrait;

    protected $policyProvider;

    function __construct($policyProvider)
    {
        $this->policyProvider = $policyProvider;
    }

    public function getPolicyProvider()
    {
        return $this->policyProvider;
    }
}