import Extend from 'flarum/common/extenders';
import app from 'flarum/admin/app';

export default [
  new Extend.Admin()
    .permission(
      () => ({
        icon: 'fas fa-eye-slash',
        label: app.translator.trans('datlechin-bbcode-hide-content.admin.permissions.bypass_like_label'),
        permission: 'post.bypassLikeRequirement',
      }),
      'view'
    )
    .permission(
      () => ({
        icon: 'fas fa-eye-slash',
        label: app.translator.trans('datlechin-bbcode-hide-content.admin.permissions.bypass_reply_label'),
        permission: 'post.bypassReplyRequirement',
      }),
      'view'
    ),
];
