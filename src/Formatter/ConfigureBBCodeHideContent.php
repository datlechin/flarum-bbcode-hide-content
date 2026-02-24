<?php

namespace Datlechin\BBCodeHideContent\Formatter;

use s9e\TextFormatter\Configurator;

class ConfigureBBCodeHideContent
{
    public function __invoke(Configurator $configurator): void
    {
        $configurator->BBCodes->addCustom(
            '[LOGIN]{TEXT}[/LOGIN]',
            '<div class="bbcode-hide-content bbcode-hide-content--login">{TEXT}</div>'
        );

        $configurator->BBCodes->addCustom(
            '[LIKE]{TEXT}[/LIKE]',
            '<div class="bbcode-hide-content bbcode-hide-content--like">{TEXT}</div>'
        );

        $configurator->BBCodes->addCustom(
            '[REPLY]{TEXT}[/REPLY]',
            '<div class="bbcode-hide-content bbcode-hide-content--reply">{TEXT}</div>'
        );
    }
}
