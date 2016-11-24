<div class="breadscrumb">
    <span><?php echo __('Language') ?></span>
    <?= $this->Html->image('System.brk_center.png') ?>
    <span><?=  $this->Html->link(__('List of the language'), array('action'=>'index')); ?></span> >
    <span><?= __('Add new key') ?></span>
</div>

<div id="center">
    <div id="right">
        <?php
            $this->loadHelper('Form', [
                'templates' => 'System.app_form',
            ]);
        ?>
        <?= $this->Form->create($language) ?>
        <table width="100%" class="tblForm">
            <tr>
                <th><?php echo __('Key') ?></th>
                <td><?php echo $this->Form->input('key', ['disabled' => !$language->isNew() ? true : false]); ?></td>
            </tr>
            <tr>
                <th><?php echo __('English') ?></th>
                <td><?php echo $this->Form->input('eng'); ?></td>
            </tr>
            <tr>
                <th><?php echo __('Vietnamese') ?></th>
                <td><?php echo $this->Form->input('vie'); ?></td>
            </tr>
            <tr>
                <th><?php echo __('Japanese') ?></th>
                <td><?php echo $this->Form->input('jpn'); ?></td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <button type="submit" class="btn btn-success"><?php echo __('Save') ?></button>
                    <button type = "button" class="btn btn-default" onclick="location.href='<?php echo $this->Url->build(['action' => 'index']); ?>';"><?php echo __("Back") ?></button>
                </td>
            </tr>
        </table>
        <?php echo $this->Form->end(); ?>

    </div>
    <!--right end-->

    <div class="cl"></div>
    <div class="height10"></div>
</div>
<script>
    $(function() {
        $('.icp-auto').iconpicker();
    });
</script>
