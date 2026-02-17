<?php

namespace huseyinfiliz\PrivateProfilePlus;

use Flarum\Extend;
use Flarum\User\User;
use Flarum\Api\Serializer\UserSerializer;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Api\Middleware\ThrottleApi;
use huseyinfiliz\PrivateProfilePlus\Middleware\CheckProfileVisibility;
use huseyinfiliz\PrivateProfilePlus\Helper\VisibilityResolver;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    (new Extend\Locales(__DIR__.'/locale')),

    (new Extend\Middleware('api'))
        ->insertBefore(ThrottleApi::class, CheckProfileVisibility::class),

    (new Extend\User())
        ->registerPreference('profileVisibility', null, 'default'),

    (new Extend\ApiSerializer(UserSerializer::class))
        ->attribute('profileVisibility', function (UserSerializer $serializer, User $user) {
            $resolver = resolve(VisibilityResolver::class);
            return $resolver->getRawPreference($user);
        })
        ->attribute('effectiveProfileVisibility', function (UserSerializer $serializer, User $user) {
            $resolver = resolve(VisibilityResolver::class);
            return $resolver->resolve($user);
        }),

    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attribute('profileVisibilityDefault', function (ForumSerializer $serializer) {
            $resolver = resolve(VisibilityResolver::class);
            return $resolver->getGlobalDefault();
        })
        ->attribute('canBypassProfileVisibility', function (ForumSerializer $serializer) {
            return $serializer->getActor()->hasPermission('huseyinfiliz-private-profile-plus.bypassProfileVisibility');
        }),

    (new Extend\Settings())
        ->default('huseyinfiliz-private-profile-plus.default_visibility', 'everyone'),
];