<?php

namespace App\Interfaces;

interface ApplicationInterface
{
    public function run(array $argv): void;
}