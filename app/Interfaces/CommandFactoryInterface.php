<?php

namespace App\Interfaces;

interface CommandFactoryInterface
{
    public function createCommand(array $arguments): ?CommandInterface;
}