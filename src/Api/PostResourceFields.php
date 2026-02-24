<?php

namespace Datlechin\BBCodeHideContent\Api;

use Flarum\Api\Context;
use Flarum\Api\Schema\Str;
use Flarum\Locale\TranslatorInterface;
use Flarum\Post\CommentPost;

class PostResourceFields
{
    public static function contentHtml(Str $field): Str
    {
        $translator = resolve(TranslatorInterface::class);
        $originalGetter = (fn () => $this->getter)->call($field);

        return $field->get(function (CommentPost $post, Context $context) use ($originalGetter, $translator) {
            $contentHtml = $originalGetter($post, $context);
            $actor = $context->getActor();

            // Guests: replace all tags with login prompt
            if ($actor->isGuest()) {
                $loginHtml = '<div class="bbcode-hide-content bbcode-hide-content--login">'
                    . $translator->trans('datlechin-bbcode-hide-content.forum.must_be_logged_in')
                    . '</div>';

                $contentHtml = preg_replace('/\[LOGIN\](.*?)\[\/LOGIN\]/s', $loginHtml, $contentHtml);
                $contentHtml = preg_replace('/\[LIKE\](.*?)\[\/LIKE\]/s', $loginHtml, $contentHtml);
                $contentHtml = preg_replace('/\[REPLY\](.*?)\[\/REPLY\]/s', $loginHtml, $contentHtml);

                return $contentHtml;
            }

            // Logged in: always reveal [LOGIN] content
            $contentHtml = preg_replace('/\[LOGIN\](.*?)\[\/LOGIN\]/s', '$1', $contentHtml);

            // Post author: always reveal [LIKE] and [REPLY] content
            if ($actor->id === $post->user_id) {
                $contentHtml = preg_replace('/\[LIKE\](.*?)\[\/LIKE\]/s', '$1', $contentHtml);
                $contentHtml = preg_replace('/\[REPLY\](.*?)\[\/REPLY\]/s', '$1', $contentHtml);

                return $contentHtml;
            }

            // [LIKE] — check if user liked or has bypass permission
            if (preg_match('/\[LIKE\].*?\[\/LIKE\]/s', $contentHtml)) {
                $liked = $post->likes()->where('user_id', $actor->id)->exists();

                if ($liked || $actor->hasPermission('post.bypassLikeRequirement')) {
                    $contentHtml = preg_replace('/\[LIKE\](.*?)\[\/LIKE\]/s', '$1', $contentHtml);
                } else {
                    $likeHtml = '<div class="bbcode-hide-content bbcode-hide-content--like">'
                        . $translator->trans('datlechin-bbcode-hide-content.forum.must_liked')
                        . '</div>';
                    $contentHtml = preg_replace('/\[LIKE\](.*?)\[\/LIKE\]/s', $likeHtml, $contentHtml);
                }
            }

            // [REPLY] — check if user replied or has bypass permission
            if (preg_match('/\[REPLY\].*?\[\/REPLY\]/s', $contentHtml)) {
                $replied = $post->mentionedBy()->where('user_id', $actor->id)->exists();

                if ($replied || $actor->hasPermission('post.bypassReplyRequirement')) {
                    $contentHtml = preg_replace('/\[REPLY\](.*?)\[\/REPLY\]/s', '$1', $contentHtml);
                } else {
                    $replyHtml = '<div class="bbcode-hide-content bbcode-hide-content--reply">'
                        . $translator->trans('datlechin-bbcode-hide-content.forum.must_replied')
                        . '</div>';
                    $contentHtml = preg_replace('/\[REPLY\](.*?)\[\/REPLY\]/s', $replyHtml, $contentHtml);
                }
            }

            return $contentHtml;
        });
    }
}
