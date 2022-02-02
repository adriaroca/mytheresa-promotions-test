<?php

namespace Tests\Feature\Application\UseCases;

use Tests\TestCase;

abstract class UseCaseBaseTest extends TestCase
{
    abstract protected function useCase(): string;

    protected function invokeUseCase(...$args)
    {
        return app()->make($this->useCase())->__invoke(...$args);
    }
}
