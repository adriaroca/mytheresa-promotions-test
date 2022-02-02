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
