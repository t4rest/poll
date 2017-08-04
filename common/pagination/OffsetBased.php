<?php

namespace common\pagination;

class OffsetBased extends Base
{
    const DEFAULT_OFFSET = 0;

    /**
     * Offset pagination value
     *
     * @var int
     */
    private $_offset = 0;

    /**
     * @var bool
     */
    private $_next = false;

    /**
     * Class constructor.
     * Sets properties
     *
     * @param int $offset . Records offset
     * @param null|int $limit . Records limit
     */
    public function __construct(int $offset = 0, int $limit = null)
    {
        $this->setOffset($offset);

        if (!is_null($limit)) {
            $this->setLimit($limit);
        }
    }

    /**
     * @param bool $next
     */
    public function setNext(bool $next = false)
    {
        $this->_next = $next;
    }

    /**
     * @return bool
     */
    public function issetNext(): bool
    {
        return $this->_next;
    }

    /**
     * Setter for offset field
     *
     * @param int $value . Value to set
     * @return OffsetBased
     */
    public function setOffset(int $value): OffsetBased
    {
        if ($value < 0) {
            $value = 0;
        }

        $this->_offset = (int)$value;

        return $this;
    }

    /**
     * Getter for offset field
     *
     * @return int|null
     */
    public function getOffset(): int
    {
        return (int)$this->_offset;
    }

    /**
     * Returns current instance in array representation
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        $offset = $this->getOffset();
        if (!empty($offset)) {
            $array['offset'] = $offset;
        }

        return $array;
    }
} 