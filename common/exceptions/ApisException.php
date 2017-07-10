<?php

namespace common\exceptions;

use common\exceptions\codes\BaseCodes;
use yii\base\Exception;
use yii\web\HttpException;

abstract class ApisException extends HttpException
{
    /**
     * Exception's error group
     */
    const CODES_GROUP = 0;

    /**
     * Error code's base full class name.
     * Is used to create codes base instance
     */
    const CODES_BASE_CLASS = '';

    /**
     * Error code's base instance,
     * to create exception from error code.
     * CodeBaseInstance must include CODES_GROUP defined in exception class
     *
     * @var null|BaseCodes
     */
    private static $_CodeBaseInstance = null;

    /**
     * Returns type of exception.
     * Usually it name of class
     *
     * @return string
     */
    public function getType(): string
    {
        $fullClassName = get_called_class();
        $classNameParts = explode('\\', $fullClassName);

        // Return class name without namespace in it (if it's present)
        return isset($classNameParts[count($classNameParts) - 1])
            ? $classNameParts[count($classNameParts) - 1]
            : $fullClassName;
    }

    /**
     * ApisException constructor.
     * @param string $status
     * @param null $message
     * @param int $code
     * @throws Exception
     */
    public function __construct($status, $message = null, $code = 0)
    {
        if (!empty($code) && !$this->validateCodeGroup($code)) {
            throw new Exception('Passed code does not match exception type');
        }

        parent::__construct($status, $message, $code);
    }

    /**
     * Validates code group.
     * Returns false if passed code does not match exception's code group - i.e.
     * passed code does not match current exception type.
     *
     * @param int $code . Code to validate
     * @return bool
     */
    protected static function validateCodeGroup(int $code): bool
    {
        $codeGroup = str_split($code, strlen((string)static::CODES_GROUP));

        return isset($codeGroup[0]) && $codeGroup[0] == static::CODES_GROUP;
    }

    /**
     * @return object
     * @throws Exception
     */
    private static function _createCodeBaseInstance(): object
    {
        $codesBaseClassName = static::CODES_BASE_CLASS;
        if (empty($codesBaseClassName)) {
            throw new Exception('CODES_BASE_CLASS must be defined');
        }

        $reflection = new \ReflectionClass($codesBaseClassName);

        return $reflection->newInstance();
    }

    /**
     * Returns codes base instance
     *
     * @return BaseCodes|null
     */
    private static function _getCodeBaseInstance()
    {
        if (empty(self::$_CodeBaseInstance)) {
            self::$_CodeBaseInstance = self::_createCodeBaseInstance();
        }

        return self::$_CodeBaseInstance;
    }

    /**
     * @param $code
     * @param array $options
     * @return ApisException|static
     * @throws Exception
     */
    public static function create($code, $options = []): ApisException
    {
        if (!self::validateCodeGroup($code)) {
            throw new Exception('Passed code does not match exception type');
        }

        $codeBase = self::_getCodeBaseInstance();
        $params = $codeBase->getInformation($code, $options);

        return new static($params['statusCode'], $params['message'], $code);
    }
}