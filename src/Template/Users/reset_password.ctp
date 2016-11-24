<?= $this->Form->create($user,['class'=>'hw-ajax1']); ?>
<table>
    <tr>
        <th><?= __('New password') ?>:</th>
        <td><?= $this->Form->input('new_password',array('type'=>'password','label'=>false,'required'=>false)) ?></td>
    </tr>
    <tr>
        <th><?= __('Confirm password') ?>:</th>
        <td><?= $this->Form->input('new_password_confirm',array('type'=>'password','label'=>false,'required'=>false)) ?></td>
    </tr>
    <tr>
        <th></th>
        <td><button type="submit"><?= __('Change password') ?></button></td>
    </tr>
</table>
<?= $this->Form->end(); ?>