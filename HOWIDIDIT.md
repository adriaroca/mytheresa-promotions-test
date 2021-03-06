# How I did it?

## Introduction

After reading the documentation to carry out the test, I have considered how to do it. Several ideas have crossed my mind. In the end I decided to do it progressively. I will start very simply and quickly to implement all the functionalities. Next, we'll add complexity to it.

### Step 1: run + framework

As a first step, I have decided to use a framework that helps me develop the main features quickly. I have chosen [Laravel](https://laravel.com/docs/8.x) as it's the framework I've used the most.

Also, the latest versions of laravel includes [sail](https://laravel.com/docs/8.x/sail). Sail is a package that provides a basic development environment.

### Step 2: Get products endpoint

I will develop the endpoint by first creating the test ([TDD](https://en.wikipedia.org/wiki/Test-driven_development) rocks :metal:).

So, we will use the facilities of `artisan` to create the files needed (controller, tests, factories, migrations...).

First, I will implement the test that filters products by category. For now, we will ignore the other requests.

### Step 3: Get products endpoint refactor

Once we have the endpoint with category filter and test coverage, we are going to refactor. What I have in mind is to separate the framework from our domain a bit. I will encapsulate the logic used in a single UseCase and abstract the [Eloquent](https://laravel.com/docs/8.x/eloquent) (Laravel's default [ORM](https://en.wikipedia.org/wiki/Object%E2%80%93relational_mapping)) using repositories. Normally I would also create a service for the product domain at this point to store all the related logic, but at the moment I don't see it necessary. I will also create separate entities and value objects.

### Step4: Return at most 5 elements

For this feature, I'm going to put limits on the results of the use case as an optional argument.

### Step 5: Apply discounts

There are three rules for applying discounts. From documentation:

- Products in the boots category have a 30% discount.
- The product with sku = 000003 has a 15% discount.
- When multiple discounts collide, the bigger discount must be applied.

I'm going to encapsulate this business logic in the `ProductPrice` domain object. For this, I will modify the price object requested in the `Product` entity constructor. Instead of an object, I'm going to ask for the integer of the price and then construct the object internally. 

I have directly hardcoded the rules in the method. This is obviously not a good solution. It could be obtained by saving the values in the database or in a configuration file.

### Step 6: Discount response with '%' sign

Reading the documentation again I have seen that the 'discount_percentage' field has to include the '%' in the response. Let's add it.

```json
{
    "products": [
        {
            "sku": "08471093",
            "name": "nkkvth vfqxe",
            "category": "boots",
            "price": {
                "original": 923577,
                "final": 646503,
                "discount_percentage": "30%",
                "currency": "EUR"
            }
        }
    ]
}
```

### Step 7: Apply discount when necessary

Discounts always apply. It would be better to add a parameter to specify if we want the discount to be applied or not. We're going to call it `discount=false`. By default, value is still true.

```http request
http://localhost:81/api/products?category=boots&discount=false
```
```json
{
    "products": [
        {
            "sku": "71909608",
            "name": "wjskcc kcabc",
            "category": "boots",
            "price": {
                "original": 35873,
                "final": 35873,
                "discount_percentage": null,
                "currency": "EUR"
            }
        }
    ]
}
```

```http request
http://localhost:81/api/products?category=boots&discount=true
```

```json
{
    "products": [
        {
            "sku": "71909608",
            "name": "wjskcc kcabc",
            "category": "boots",
            "price": {
                "original": 35873,
                "final": 35873,
                "discount_percentage": null,
                "currency": "EUR"
            }
        }
    ]
}
```

### Pending tasks

- I have discarded the functionality to order prices due to lack of time.
- Add an Api Key.
- Indexing / caching system to speed up searches and responses.
- It would be interesting to modify the folder structure. I would rename the `app` folder to `src` and classify its contents into three folders: Domain (already exists), Application, Infrastructure.

```shell
- src
-- Application
  - Http
  - Models
  - Providers
  - UseCases
-- Domain
  - Entities
  - Repositories (contracts)
  - Values
-- Infraestructure
  - Mappers
  - Repositories (implementation)
```
