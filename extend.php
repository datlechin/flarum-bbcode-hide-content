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

use Datlechin\BBCodeHideContent\Api\PostResourceFields;
use Flarum\Api\Resource\PostResource;
use Flarum\Extend;

return [
    (new Extend\Frontend('forum'))
        ->css(__DIR__ . '/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),

    new Extend\Locales(__DIR__ . '/locale'),

    (new Extend\ApiResource(PostResource::class))
        ->field('contentHtml', PostResourceFields::contentHtml(...)),
];
