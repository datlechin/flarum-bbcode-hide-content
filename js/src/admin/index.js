import app from 'flarum/admin/app';

app.initializers.add('datlechin/flarum-bbcode-hide-content', () => {
  app.extensionData
    .for('datlechin-bbcode-hide-content')
    .registerPermission(
      {
        icon: 'fas fa-eye-slash',
        label: app.translator.trans('datlechin-bbcode-hide-content.admin.permissions.bypass_like_label'),
        permission: 'post.bypassLikeRequirement',
      },
      'view'
    )
    .registerPermission(
      {
        icon: 'fas fa-eye-slash',
        label: app.translator.trans('datlechin-bbcode-hide-content.admin.permissions.bypass_reply_label'),
        permission: 'post.bypassReplyRequirement',
      },
      'view'
    );
});
