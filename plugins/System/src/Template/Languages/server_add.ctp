<div class="breadscrumb">
    <span><?php echo __('Language') ?></span>
    <?= $this->Html->image('System.brk_center.png') ?>
    <span><?=  $this->Html->link(__('Server management'), array('action'=>'server_index')); ?></span> >
    <span><?= __('Add new key to server') ?></span>
</div>

<div id="center">
    <div id="right">
        <?php
        $this->loadHelper('Form', [
            'templates' => 'System.app_form',
        ]);
        ?>
        <?= $this->Form->create(null) ?>
        <table width="100%" class="tblForm">
        <?php
        foreach($colTblServer as $field):
            if ($field == 'id') continue;
        ?>
            <tr>
                <th><?php echo ucwords($field) ?></th>
                <td><?php echo $this->Form->input($field); ?></td>
            </tr>
        <?php endforeach;?>
            <tr>
                <th></th>
                <td>
                    <button type="submit" class="btn btn-success"><?php echo __('Save') ?></button>
                    <button type = "button" class="btn btn-default" onclick="location.href='<?php echo $this->Url->build(['action' => 'server_index']); ?>';"><?php echo __('Back') ?></button>
                </td>
            </tr>
        </table>
        <?php echo $this->Form->end(); ?>

    </div>
    <!--right end-->

    <div class="cl"></div>
    <div class="height10"></div>
</div>
