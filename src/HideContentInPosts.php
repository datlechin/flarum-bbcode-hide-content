<?php

namespace Datlechin\BBCodeHideContent;

use Flarum\Api\Serializer\PostSerializer;
use Flarum\Post\Post;
use Flarum\Settings\SettingsRepositoryInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class HideContentInPosts
{
    protected TranslatorInterface $translator;
    protected SettingsRepositoryInterface $settings;

    public function __construct(TranslatorInterface $translator, SettingsRepositoryInterface $settings)
    {
        $this->translator = $translator;
        $this->settings = $settings;
    }

    public function __invoke(PostSerializer $serializer, Post $post, array $attributes): array
    {
        $discussion = $post->discussion;
        $actor = $serializer->getActor();

        if (isset($attributes['contentHtml'])) {
            $contentHtml = $attributes['contentHtml'];

            if ($actor->isGuest()) {
                $contentHtml = preg_replace('/\[LIKE\](.*?)\[\/LIKE\]/s', $this->loginHtml(), $contentHtml);
                $contentHtml = preg_replace('/\[REPLY\](.*?)\[\/REPLY\]/s', $this->loginHtml(), $contentHtml);
                $contentHtml = preg_replace('/\[LOGIN\](.*?)\[\/LOGIN\]/s', $this->loginHtml(), $contentHtml);
            }
    
            if ($actor->id === $post->user_id) {
                $contentHtml = preg_replace('/\[(.*?)\]/', '', $contentHtml);
            }
    
            if (preg_match('/\[LIKE\](.*?)\[\/LIKE\]/', $contentHtml)) {
                $liked = $actor->id && $post->likes()->where('user_id', $actor->id)->exists();
    
                if ($liked || $actor->hasPermission('post.bypassLikeRequirement')) {
                    $contentHtml = preg_replace('/\[LIKE\](.*?)\[\/LIKE\]/s', '$1', $contentHtml);
                } else {
                    $contentHtml = preg_replace('/\[LIKE\](.*?)\[\/LIKE\]/s', $this->likeHtml(), $contentHtml);
                }
            }
    
            if (preg_match('/\[REPLY\](.*?)\[\/REPLY\]/', $contentHtml)) {
                $replied = $post->mentionedBy()->where('user_id', $actor->id)->exists();
    
                if ($replied || $actor->hasPermission('post.bypassReplyRequirement')) {
                    $contentHtml = preg_replace('/\[REPLY\](.*?)\[\/REPLY\]/s', '$1', $contentHtml);
                } else {
                    $contentHtml = preg_replace('/\[REPLY\](.*?)\[\/REPLY\]/s', $this->replyHtml(), $contentHtml);
                }
            }
    
            $attributes['contentHtml'] = $contentHtml;
        }

        return $attributes;
    }

    protected function loginHtml(): string
    {
        return '<div class="bbcode-hide-content login">' . $this->translator->trans('datlechin-bbcode-hide-content.forum.must_be_logged_in') . '</div>';
    }

    protected function likeHtml(): string
    {
        return '<div class="bbcode-hide-content like">' . $this->translator->trans('datlechin-bbcode-hide-content.forum.must_liked') . '</div>';
    }

    protected function replyHtml(): string
    {
        return '<div class="bbcode-hide-content like">' . $this->translator->trans('datlechin-bbcode-hide-content.forum.must_replied') . '</div>';
    }
}
