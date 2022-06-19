# BBCode Hide Content

![License](https://img.shields.io/badge/license-MIT-blue.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/datlechin/flarum-bbcode-hide-content.svg)](https://packagist.org/packages/datlechin/flarum-bbcode-hide-content) [![Total Downloads](https://img.shields.io/packagist/dt/datlechin/flarum-bbcode-hide-content.svg)](https://packagist.org/packages/datlechin/flarum-bbcode-hide-content)

A [Flarum](http://flarum.org) extension. Gives users the ability to hide content from other users using BBCode.

![](https://i.imgur.com/Oxid9nn.png)
![](https://i.imgur.com/j4OeLrQ.png)
![](https://i.imgur.com/JrcYCv1.png)

## How to use

- Add the following BBCode to your post:
- `[LIKE]content to hide[/LIKE]`: hides the content until the user likes the post
- `[REPLY]content to hide[/REPLY]`: hides the content until the user replies to the post

## Installation

Install with composer:

```sh
composer require datlechin/flarum-bbcode-hide-content:"*"
```

## Updating

```sh
composer update datlechin/flarum-bbcode-hide-content:"*"
php flarum migrate
php flarum cache:clear
```

## Links

- [Packagist](https://packagist.org/packages/datlechin/flarum-bbcode-hide-content)
- [GitHub](https://github.com/datlechin/flarum-bbcode-hide-content)
- [Discuss](https://discuss.flarum.org/d/PUT_DISCUSS_SLUG_HERE)
