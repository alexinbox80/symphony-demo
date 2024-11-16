<?php

namespace App\ValueObject;

enum UserRoleEnum: string
{
    case ROLE_ADMIN = 'ROLE_ADMIN';

    case ROLE_USER = 'ROLE_USER';

    case ROLE_MANAGER = 'ROLE_MANAGER';

    case ROLE_GUEST = 'ROLE_GUEST';

    public function label(): string {
        return UserRoleEnum::getLabel($this);
    }
    public static function getLabel(self $value): string
    {
        return match ($value)
        {
            UserRoleEnum::ROLE_ADMIN => 'User with admin privileges' . UserRoleEnum::ROLE_ADMIN->value,
            UserRoleEnum::ROLE_USER  => 'User with user privileges' . UserRoleEnum::ROLE_USER->value,
            UserRoleEnum::ROLE_MANAGER => 'User with manager privileges' . UserRoleEnum::ROLE_MANAGER->value,
            UserRoleEnum::ROLE_GUEST => 'User with guest privileges' . UserRoleEnum::ROLE_GUEST->value
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
