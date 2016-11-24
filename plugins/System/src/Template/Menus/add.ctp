<div class="breadscrumb">
    <span><?php echo __('System') ?></span>
    <?= $this->Html->image('System.brk_center.png') ?>
    <span><?=  $this->Html->link(__('List of the menus'), array('action'=>'index', $groupId)); ?></span> >
    <span><?= __('Menu add') ?></span>
</div>

<div id="center">
    <div id="right">
        <?php
        $this->loadHelper('Form', [
            'templates' => 'System.app_form',
        ]);
        ?>
        <?= $this->Form->create($menu) ?>

        <table width="100%" class="tblForm">
            <tr>
                <th width="30%"><?php echo __('Parent') ?></th>
                <td width="70%"><?php echo $this->Form->select('parent_id', $parents, ['empty' => '--Select parent--']); ?></td>
            </tr>
            <tr>
                <th><?php echo __('Name') ?></th>
                <td><?php echo $this->Form->input('name'); ?></td>
            </tr>
            <tr>
                <th><?php echo __('Icon') ?></th>
                <td>
                    <div class="input-group">
                        <input class="form-control icp icp-auto" name="icon" value="fa-archive" type="text" size="50" />
                        <span class="input-group-addon"></span>
                    </div>
                </td>
            </tr>
            <tr>
                <th><?php echo __('Plugin') ?></th>
                <td><?php echo $this->Form->select('plugin', $listPlugin, ['empty' => '--- '.__('Select plugin').' ---']); ?></td>
            </tr>
            <tr>
                <th><?php echo __('Controller') ?></th>
                <td><?php echo $this->Form->input('controller'); ?></td>
            </tr>
            <tr>
                <th><?php echo __('Action') ?></th>
                <td><?php echo $this->Form->input('action'); ?></td>
            </tr>
            <tr>
                <th><?php echo __('Highlight') ?></th>
                <td>
                    <?php echo $this->Form->input('highlight',['label'=>false,'type'=>'textarea','placeholder'=>"users/index\r\nusers/add\r\nusers/edit", 'rows'=>10,'style'=>'width:100%']); ?>
                    <p>Active (highlight) the left menu item corresponding to the controller/action above.</p>
                </td>
            </tr>
            <tr>
                <th><?php echo __('Display') ?></th>
                <td><?php echo $this->Form->checkbox('display',array('label'=>false, 'required'=>false)); ?></td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <button type="submit" class="btn_small_blue"><?php echo __('Save') ?></button>
                    <button type = "button" class="btn_small_blue" onclick="location.href='<?php echo $this->Url->build(['action' => 'index', $groupId]); ?>';"><?php echo __('Back') ?></button>
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
