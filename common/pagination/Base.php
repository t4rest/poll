<?php

namespace backend\api\pagination;

abstract class Base
{
    /**
     * Default limit value
     */
    const DEFAULT_LIMIT = 50;

    /**
     * Maximum limit value
     */
    const MAX_LIMIT = 100;

    /**
     * Records limit value
     *
     * @var int
     */
    private $_limit = self::DEFAULT_LIMIT;

    /**
     * Setter for limit field
     *
     * @param int $value . Value to set
     * @return Base
     */
    public function setLimit(int $value): Base
    {
        if ($value < 0) {
            $value = 0;
        }

        $this->_limit = (int)min($value, self::MAX_LIMIT);

        return $this;
    }

    /**
     * Getter of limit field
     *
     * @return int
     */
    public function getLimit(): int
    {
        return (int)$this->_limit;
    }

    /**
     * Returns current object in array representation
     *
     * @return array
     */
    abstract function toArray(): array;
}
