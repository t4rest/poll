<?php

namespace common\clients;

interface ClintInterface
{
    public function getClientId(): int;

    public function getUserDbAttributes(array $data = []): array;

    public function post(): bool;
}