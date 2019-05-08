<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: AR_Gwada
 * Date: 2019-05-05
 * Time: 15:34.
 */

namespace ValueObject;

final class IdentityValueObject
{
    const MIN_LENGTH_VALUE = 2;
    const MAX_LENGTH_VALUE = 50;

    private $firstName;
    private $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        if (empty($firstName) || empty($lastName)) {
            throw new \InvalidArgumentException(' Identity incomplete');
        }

        if (!$this->checkingLength($firstName, $lastName)) {
            throw new \InvalidArgumentException(' Identity doesn\t not respect the pattern');
        }

        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }


    public function checkingLength(string $firstName, string $lastName): bool
    {
        $checkingOk = false;
        $parameters = func_get_args();

        foreach ($parameters as $value) {
            $checkingOk = $this->minlength($value);
        }

        return $checkingOk;
    }

    public function minLength(string $value): bool
    {
        if (strlen($value) < self::MIN_LENGTH_VALUE) {
            return false;
        }

        return $this->maxLength($value);
    }

    public function maxLength(string $value): bool
    {
        if (strlen($value) > self::MAX_LENGTH_VALUE) {
            return false;
        }

        return true;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }
}
