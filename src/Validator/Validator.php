<?php
declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator
{
    public function __construct(
        private readonly ValidatorInterface $validator,
    ) {}

    public function validate(object $value): void
    {
        $errors = $this->validator->validate($value);
        if (count($errors) > 0) {
            throw new ValidatorException((string) $errors, 422);
        }
    }
}
