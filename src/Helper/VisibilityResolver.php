<?php

namespace huseyinfiliz\PrivateProfilePlus\Helper;

use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\User;

class VisibilityResolver
{
    const VISIBILITY_EVERYONE = 'everyone';
    const VISIBILITY_MEMBERS = 'members';
    const VISIBILITY_PRIVATE = 'private';
    const VISIBILITY_DEFAULT = 'default';

    const VALID_LEVELS = [
        self::VISIBILITY_EVERYONE,
        self::VISIBILITY_MEMBERS,
        self::VISIBILITY_PRIVATE,
    ];

    const SETTINGS_KEY = 'huseyinfiliz-private-profile-plus.default_visibility';

    protected SettingsRepositoryInterface $settings;

    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Get the admin-configured global default visibility level.
     */
    public function getGlobalDefault(): string
    {
        $value = $this->settings->get(self::SETTINGS_KEY, self::VISIBILITY_EVERYONE);

        return in_array($value, self::VALID_LEVELS, true)
            ? $value
            : self::VISIBILITY_EVERYONE;
    }

    /**
     * Get the user's raw preference value (may be 'default', null, or a level).
     */
    public function getRawPreference(User $user): string
    {
        $pref = $user->getPreference('profileVisibility');

        if (empty($pref) || $pref === self::VISIBILITY_DEFAULT) {
            return self::VISIBILITY_DEFAULT;
        }

        return in_array($pref, self::VALID_LEVELS, true)
            ? $pref
            : self::VISIBILITY_DEFAULT;
    }

    /**
     * Resolve the effective visibility for a user.
     * If user's preference is 'default' (or null/empty), use admin global default.
     *
     * Returns one of: 'everyone', 'members', 'private'
     */
    public function resolve(User $user): string
    {
        $raw = $this->getRawPreference($user);

        if ($raw === self::VISIBILITY_DEFAULT) {
            return $this->getGlobalDefault();
        }

        return $raw;
    }

    /**
     * Determine if the given actor can view the given profile owner's profile.
     */
    public function canView(User $profileOwner, ?User $actor): bool
    {
        $effective = $this->resolve($profileOwner);

        switch ($effective) {
            case self::VISIBILITY_EVERYONE:
                return true;

            case self::VISIBILITY_MEMBERS:
                return $actor !== null && !$actor->isGuest();

            case self::VISIBILITY_PRIVATE:
                if ($actor === null || $actor->isGuest()) {
                    return false;
                }

                return $actor->id === $profileOwner->id
                    || $actor->hasPermission('huseyinfiliz-private-profile-plus.bypassProfileVisibility');

            default:
                return true;
        }
    }
}
