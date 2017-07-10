<?php

namespace backend\modules\user\datatypes;

use common\datatypes\Structure;
use common\models\User;

class UserStructure implements Structure
{
    /**
     * @var User
     */
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function serialize(): array
    {
        $user = [
            'id' => $this->user->id,
            'email' => $this->user->email,
            'username' => $this->user->username,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'photo_url' => $this->user->photo_url,
            'timezone' => $this->user->timezone,
            'locale' => $this->user->locale,
            'created_at' => $this->user->created_at,
            'updated_at' => $this->user->updated_at,
        ];

//        if($)

        return $user;
    }
}








