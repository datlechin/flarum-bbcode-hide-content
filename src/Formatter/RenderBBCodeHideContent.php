<?php

namespace Datlechin\BBCodeHideContent\Formatter;

use Flarum\Http\RequestUtil;
use Flarum\Locale\TranslatorInterface;
use Flarum\Post\CommentPost;
use Flarum\User\Guest;
use Psr\Http\Message\ServerRequestInterface;
use s9e\TextFormatter\Renderer;

class RenderBBCodeHideContent
{
    public function __construct(
        protected TranslatorInterface $translator
    ) {
    }

    public function __invoke(Renderer $renderer, mixed $context, string $xml, ?ServerRequestInterface $request = null): string
    {
        if (! $context instanceof CommentPost) {
            return $xml;
        }

        if (! $this->containsHideTags($xml)) {
            return $xml;
        }

        $actor = $request ? RequestUtil::getActor($request) : new Guest();
        $post = $context;

        if ($actor->isGuest()) {
            $message = $this->translator->trans('datlechin-bbcode-hide-content.forum.must_be_logged_in');

            $xml = $this->hideTag($xml, 'LOGIN', $message);
            $xml = $this->hideTag($xml, 'LIKE', $message);
            $xml = $this->hideTag($xml, 'REPLY', $message);

            return $xml;
        }

        $xml = $this->revealTag($xml, 'LOGIN');

        if ($actor->id === $post->user_id) {
            $xml = $this->revealTag($xml, 'LIKE');
            $xml = $this->revealTag($xml, 'REPLY');

            return $xml;
        }

        if ($this->hasTag($xml, 'LIKE')) {
            $liked = method_exists($post, 'likes')
                && $post->likes()->where('user_id', $actor->id)->exists();

            if ($liked || $actor->hasPermission('post.bypassLikeRequirement')) {
                $xml = $this->revealTag($xml, 'LIKE');
            } else {
                $xml = $this->hideTag($xml, 'LIKE', $this->translator->trans('datlechin-bbcode-hide-content.forum.must_liked'));
            }
        }

        if ($this->hasTag($xml, 'REPLY')) {
            $replied = method_exists($post, 'mentionedBy')
                && $post->mentionedBy()->where('user_id', $actor->id)->exists();

            if ($replied || $actor->hasPermission('post.bypassReplyRequirement')) {
                $xml = $this->revealTag($xml, 'REPLY');
            } else {
                $xml = $this->hideTag($xml, 'REPLY', $this->translator->trans('datlechin-bbcode-hide-content.forum.must_replied'));
            }
        }

        return $xml;
    }

    private function containsHideTags(string $xml): bool
    {
        return (bool) preg_match('/\[LOGIN\]|<LOGIN[ >]|\[LIKE\]|<LIKE[ >]|\[REPLY\]|<REPLY[ >]/', $xml);
    }

    private function hasTag(string $xml, string $tag): bool
    {
        return (bool) preg_match('/\[' . $tag . '\]|<' . $tag . '[ >]/', $xml);
    }

    private function revealTag(string $xml, string $tag): string
    {
        $xml = preg_replace(
            '/<' . $tag . '><s>\[' . $tag . '\]<\/s>(.*?)<e>\[\/' . $tag . '\]<\/e><\/' . $tag . '>/s',
            '$1',
            $xml
        );

        $xml = preg_replace('/\[' . $tag . '\](.*?)\[\/' . $tag . '\]/s', '$1', $xml);

        return $xml;
    }

    private function hideTag(string $xml, string $tag, string $message): string
    {
        $escapedMessage = htmlspecialchars($message, ENT_XML1);
        $replacement = '<' . $tag . '>' . $escapedMessage . '</' . $tag . '>';

        $xml = preg_replace(
            '/<' . $tag . '><s>\[' . $tag . '\]<\/s>.*?<e>\[\/' . $tag . '\]<\/e><\/' . $tag . '>/s',
            $replacement,
            $xml
        );

        if (preg_match('/\[' . $tag . '\].*?\[\/' . $tag . '\]/s', $xml)) {
            if (str_starts_with($xml, '<t>') && str_ends_with($xml, '</t>')) {
                $xml = '<r>' . substr($xml, 3, -4) . '</r>';
            }

            $xml = preg_replace('/\[' . $tag . '\].*?\[\/' . $tag . '\]/s', $replacement, $xml);
        }

        return $xml;
    }
}
