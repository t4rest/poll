<?php
namespace common\exceptions\codes;

abstract class BaseCodes
{
    /**
     * @return array
     */
    abstract protected function library() : array;

    /**
     * @param $code
     * @param $options
     * @return array
     */
    public function getInformation($code, $options = array()) : array
    {
        $library = $this->library();
        if (!isset($library[$code])) {
            return $this->defaultInformation();
        }

        return $this->prepare($library[$code], $options);
    }

    /**
     * Prepare code information
     * @param array $info
     * @param array $options
     * @return array
     */
    protected function prepare(array $info, array $options = array()) : array
    {
        $statusCode = $info['statusCode'];
        if (isset($options['statusCode'])) {
            $statusCode = $options['statusCode'];
            unset($options['statusCode']);
        }

        $message = $info['message'];
        if (isset($options['message'])) {
            $message = $options['message'];
            unset($options['message']);
        }

        foreach ($options as $key => $value) {
            $message = str_replace('{' . $key . '}', $value, $message);
        }

        return [
            'statusCode' => $statusCode,
            'message' => $message
        ];
    }

    /**
     * @return array
     */
    protected function defaultInformation() : array
    {
        return [
            'statusCode' => 500,
            'message' => 'Internal server error'
        ];
    }
}