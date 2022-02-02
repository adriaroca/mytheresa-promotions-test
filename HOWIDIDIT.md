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
