<?php

declare(strict_types=1);

namespace App\Validators;

use CQ\Validators\Validator;
use Respect\Validation\Validator as v;

class RoomValidator extends Validator
{
    /**
     * Validate json submission.
     */
    public static function update(object $data): void
    {
        $v = v::attribute('size_m2', v::alnum()->length(1, 64))
            ->attribute('monthly_price', v::alnum()->length(1, 64))
            ->attribute('address', v::alnum()->length(1, 64));

        self::validate($v, $data);
    }
}
