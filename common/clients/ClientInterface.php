<?php

namespace common\clients;

use common\models\Auth;
use common\models\Poll;

interface ClientInterface
{
    public function getClientId(): int;

    public function getUserDbAttributes(array $data = []): array;

    public function setClientToken(Auth $as);

    public function post(Poll $poll): bool;
}