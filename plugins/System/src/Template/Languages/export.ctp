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
            $lang = [];
            foreach (\Cake\Core\Configure::read('Core.System.language') as $key => $value) {
                $lang = array_merge($lang, [$key => $value['name']]);
            }
        ?>
        <?= $this->Form->create(null) ?>
        <table width="100%" class="tblForm">
            <tr>
                <th><?php echo __('English') ?></th>
                <td><?php echo $this->Form->select('language', $lang); ?></td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <button type="submit" class="btn btn-success"><?php echo __('Export') ?></button>
                    <button type = "button" class="btn btn-default" onclick="location.href='<?php echo $this->Url->build(['action' => 'index']); ?>';"><?php echo __('Back') ?></button>
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
