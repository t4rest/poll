<?php

namespace common\pagination;

class TimeBased extends Base
{
    /**
     * Time point, from which older entities are returned
     *
     * @var mixed
     */
    private $_since = null;

    /**
     * Time point, from which newest entities are returned
     *
     * @var mixed
     */
    private $_until = null;

    /**
     * Class constructor.
     * Sets passed arguments
     *
     * @param mixed $since . Pagination "since" part - date, from which older entities are returned
     * @param mixed $until . Pagination "until" part - date, from which newest entities are returned
     * @param null|int $limit . Records limit
     */
    public function __construct($since = null, $until = null, $limit = null)
    {
        $this->setSince($since);
        $this->setUntil($until);

        if (!is_null($limit)) {
            $this->setLimit($limit);
        }
    }

    /**
     * Setter for since field
     *
     * @param mixed $value . Value to set
     * @return $this
     */
    public function setSince($value)
    {
        $this->_since = $value;

        return $this;
    }

    /**
     * Getter for since field
     *
     * @return mixed
     */
    public function getSince()
    {
        return $this->_since;
    }

    /**
     * Setter for until field
     *
     * @param mixed $value . Value to set
     * @return $this
     */
    public function setUntil($value)
    {
        $this->_until = $value;

        return $this;
    }

    /**
     * Getter for until field
     *
     * @return mixed
     */
    public function getUntil()
    {
        return $this->_until;
    }

    /**
     * Returns current instance in array representation
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        $since = $this->getSince();
        $until = $this->getUntil();

        if (!empty($since)) {
            $array['since'] = $since;
        }

        if (!empty($until)) {
            $array['until'] = $until;
        }

        return $array;
    }
} 