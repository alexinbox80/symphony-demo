<?php

namespace App\Factory;

use App\Entity\Profile;
use App\Entity\User;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Profile>
 */
final class ProfileFactory extends PersistentProxyObjectFactory
{

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Profile::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->firstName,
            'surname' => self::faker()->lastName,
            'nickname' => self::faker()->userName(),
            'phone' => self::faker()->phoneNumber,
            'avatar' => self::faker()->filePath(),
            'address' => self::faker()->address,
            //'user_id' => UserFactory::createOne()->getId()
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this// ->afterInstantiate(function(Profile $profile): void {})
            ;
    }
}
