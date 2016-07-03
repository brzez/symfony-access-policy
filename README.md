# symfony-access-policy

## Overview

Access checker, inspired by [Laravel](https://laravel.com/docs/5.1/authorization#checking-abilities).

It allows for checking access via simple **can** and **cannot** methods accessible via the *brzez_access_policy.access_policy_provider* service.

It also extends twig with those two methods as global functions.

**can** needs minimum 2 arguments:
- intent - what are you checking access for ex. *view*, *edit* etc
- object - what object are you checking the access for
**cannot** is just an inverse of **can** (so !can())

It is also possible to pass additional variables to the can/cannot methods.

The **2nd** arg is always used for finding the matching policy.

The rest are just passed to the policy **can*()** method.

Policy needs to implement **AccessPolicyInterface** which requires the **getPoliciedClass** method.

Policies are registered as services.

The policy service needs to be tagged as *access_policy* so it will be recognized by the access policy provider.

## Installation

``` bash
composer require brzez/access-policy-bundle
```

Enable the bundle in the kernel


``` php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        //...
        new Brzez\AccessPolicyBundle\BrzezAccessPolicyBundle(),
        //...
    );
    return $bundles;
}
```

## Registering policies
In **services.yml**

```yml
services:
  test_policy:
    class: AppBundle\TestPolicy
    tags:
      - {name: access_policy}
```

## Naming intent methods
When using **can**/**cannot** methods the intent is written in kebab-case, without the can/cannot word.

Example:
```php
// Will run canChangeStatus($something) on the policy
$this->can('change-status', $something);

// Will return negated canChangeStatus($something)
$this->cannot('change-status', $something);
```

## Usage
*PolicyProvider* can be accessed via container

```php
$container->get('brzez_access_policy.access_policy_provider')
```

Controllers can use **Brzez\AccessPolicyBundle\Traits\AccessCheckerTrait** which will extend the controller by adding:
- can(intent, object)
- cannot(intent, object)
- getPolicyProvider()
methods

It also adds twig global functions - **can(...)** and **cannot(...)** which can be used like this:
```twig
    {% if can('view', someObject) %}
        i can view someObject
    {% endif %}
    {% if cannot('view', someObject) %}
        i cannot view someObject
    {% endif %}
```

## Example

Let's say we have **SomeEntity** and we need to check **view** access via our policy.

We need to create **SomeEntityPolicy** with **canView** method.
```php
use Brzez\AccessPolicyBundle\Service\AccessPolicyInterface;

class SomeEntityPolicy implements AccessPolicyInterface
{
    public function canView(SomeEntity $entity)
    {
        // access logic here
        return false;
    }
}
```

Link the policy to the entity

In **app/config/services.yml**

```yml
services:
  test_policy:
    class: AppBundle\SomeEntityPolicy
    tags:
      - {name: access_policy}
```

Now you can check access in the controller:
```php

use Brzez\AccessPolicyBundle\Traits\AccessCheckerTrait;

class DefaultController extends Controller
{
    use AccessCheckerTrait;
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // get $someObject from somewhere
        ...
        
        if($this->cannot('view', $someObject)){
            throw new AccessDeniedException('...');
        }
        
        // render view
        ...
    }
}
```

You can also check access in twig views:

```twig
    {% if can('view', someObject) %}
        i can view someObject
    {% endif %}
    {% if cannot('view', someObject) %}
        i cannot view someObject
    {% endif %}
```
