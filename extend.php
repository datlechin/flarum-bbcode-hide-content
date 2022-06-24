<?php

/*
 * This file is part of datlechin/flarum-bbcode-hide-content.
 *
 * Copyright (c) 2022 Ngo Quoc Dat.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Datlechin\BBCodeHideContent;

use Datlechin\BBCodeHideContent\Access\UserPolicy;
use Flarum\Api\Serializer\PostSerializer;
use Flarum\Extend;
use Flarum\User\User;

return [
    (new Extend\Frontend('forum'))
        ->css(__DIR__ . '/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),

    new Extend\Locales(__DIR__ . '/locale'),

    (new Extend\ApiSerializer(PostSerializer::class))
        ->attributes(HideContentInPosts::class),
];
