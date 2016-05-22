# symfony-access-policy

## Overview

This is a access checker, inspired by [Laravel](https://laravel.com/docs/5.1/authorization#checking-abilities).

It allows for checking access via simple **can** and **cannot** methods accessible via the *brzez_access_policy.access_policy_provider* service.

It also extends twig with those two methods as global functions.

**can** needs minimum 2 arguments:
- intent - what are you checking access for ex. *view*, *edit* etc
- object - what object are you checking the access for
**cannot** is just an inverse of **can** (so !can())

It is also possible to pass additional variables to the can/cannot methods.

The **2nd** arg is always used for finding the matching policy.

The rest are just passed to the policy **can*()** method.


Policy needs to extend **ContainerAwareAccessPolicy** or **AccessPolicy**

*ContainerAwareAccessPolicy* adds container access.

**intent** passed to can/cannot methods is written in *kebab-case*.

It is then transformed to camelCase and the *can* prefix is added.

Which means that intent *edit-user-data* will mean running *canEditUserData* method on the appropriate policy.

There is a *todo* for adding policies as services, which would probably be more 'Symfony way' - full container access is bad.

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

## Configuration
In **app/config/config.yml**

```yml
brzez_access_policy:
    policies:
        - {class: \AppBundle\SomeEntity, policy: AppBundle\SomeEntityPolicy}
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
use Brzez\AccessPolicyBundle\Service\ContainerAware\ContainerAwareAccessPolicy;

class SomeEntityPolicy extends ContainerAwareAccessPolicy
{
    public function canView(SomeEntity $entity)
    {
        // access logic here
        // you can use $this->get to access services from container.
        // this is a easy way to get the current user etc.
        return false;
    }
}
```

Link the policy to the entity

In **app/config/config.yml**

```yml
brzez_access_policy:
    policies:
        - {class: \AppBundle\SomeEntity, policy: AppBundle\SomeEntityPolicy}
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
