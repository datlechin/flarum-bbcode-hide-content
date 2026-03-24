import app from 'flarum/forum/app';
import { extend } from 'flarum/common/extend';
import styleSelectedText from 'flarum/common/utils/styleSelectedText';
import TextEditorButton from 'flarum/common/components/TextEditorButton';

extend('flarum/common/components/TextEditor', 'toolbarItems', function (items) {
  const applyBBCode = (tag) => {
    const prefix = `[${tag}]`;
    const suffix = `[/${tag}]`;
    styleSelectedText(this.attrs.composer.editor.el, { prefix, suffix, trimFirst: true });
  };

  items.add(
    'bbcode-hide-login',
    <TextEditorButton onclick={() => applyBBCode('LOGIN')} icon="fas fa-sign-in-alt">
      {app.translator.trans('datlechin-bbcode-hide-content.forum.composer.hide_login_tooltip')}
    </TextEditorButton>
  );

  items.add(
    'bbcode-hide-like',
    <TextEditorButton onclick={() => applyBBCode('LIKE')} icon="fas fa-thumbs-up">
      {app.translator.trans('datlechin-bbcode-hide-content.forum.composer.hide_like_tooltip')}
    </TextEditorButton>
  );

  items.add(
    'bbcode-hide-reply',
    <TextEditorButton onclick={() => applyBBCode('REPLY')} icon="fas fa-reply">
      {app.translator.trans('datlechin-bbcode-hide-content.forum.composer.hide_reply_tooltip')}
    </TextEditorButton>
  );
});

export default [];
