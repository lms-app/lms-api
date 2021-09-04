<?php
declare(strict_types=1);

namespace Modules\Entity\ValidationRules;


use Illuminate\Contracts\Validation\Rule;
use Modules\Entity\Exceptions\InvalidEntityStatusException;
use Modules\Entity\ValueObjects\EntityStatus;

class EntityStatusRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        if ($attribute !== 'status') {
            return false;
        }

        try {
            EntityStatus::create(
                $value
            );
            return true;
        } catch (InvalidEntityStatusException $exception) {
            return false;
        }
    }

    public function message(): string
    {
        return InvalidEntityStatusException::ENTITY_STATUS_INVALID_MESSAGE;
    }
}
