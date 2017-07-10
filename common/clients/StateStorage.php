<?php

namespace common\clients;

use Yii;
use yii\authclient\StateStorageInterface;

trait StateStorage
{
    /**
     * @var TokenStorage
     */
    private $_stateStorage;

    /**
     * @return StateStorageInterface stage storage.
     */
    public function getStateStorage()
    {
        if (!is_object($this->_stateStorage)) {
            $this->_stateStorage = Yii::createObject(TokenStorage::class);
        }
        return $this->_stateStorage;
    }

    /**
     * @param StateStorageInterface|array|string $stateStorage stage storage to be used.
     */
    public function setStateStorage($stateStorage)
    {
        $this->_stateStorage = $stateStorage;
    }
}