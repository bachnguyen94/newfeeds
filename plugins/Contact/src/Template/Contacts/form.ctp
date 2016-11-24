<?= $this->Form->create($contact, ['id' => 'smart-form-register', 'class' => '']) ?>
<table width="100%" class="tblForm">
    <tr>
        <th colspan="2"><?php echo __('Contact') ?></th>
    </tr>
    <tr>
        <th><?php echo __('Name') ?></th>
        <td><?= $this->Form->input('name', ['placeholder' => __('Name'),'label'=>false,'required'=>false]) ?></td>
    </tr>
    <tr>
        <th><?php echo __('Email') ?></th>
        <td><?= $this->Form->input('email', ['placeholder' => __('Email'),'type'=>'text','label'=>false,'required'=>false]) ?></td>
    </tr>
    <tr>
        <th><?php echo __('Phone') ?></th>
        <td><?= $this->Form->input('phone', ['placeholder' => __('Phone'),'label'=>false,'required'=>false]) ?></td>
    </tr>
    <tr>
        <th><?php echo __('Address') ?></th>
        <td><?= $this->Form->input('address', ['placeholder' => __('Address'),'label'=>false]) ?></td>
    </tr>
    <tr>
        <th><?php echo __('Content') ?></th>
        <td><?= $this->Form->input('content', ['type'=>'textarea','placeholder' => __('Content'),'label'=>false,'required'=>false]) ?></td>
    </tr>
    <tr>
        <th width="30%"></th>
        <td>
            <?= $this->Form->button(__('Submit'), ['class' => 'btn']) ?>
        </td>
    </tr>
</table>
<?= $this->Form->end() ?>
    