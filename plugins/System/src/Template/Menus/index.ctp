<?php
    $pGroupID = $this->request->params['pass'][0];
    $pPluginName = (isset($this->request->params['pass'][1]))?$this->request->params['pass'][1]:null;
?>
<div class="breadscrumb">
    <span><?php echo __("System") ?></span>
    <?= $this->Html->image('System.brk_center.png') ?>
    <span><?php echo __("Menu management") ?></span>
</div>

<div id="center">
    <div id="left">
        <div class="left_top"><?php echo __('User group') ?></div>
        <div class="content_left">
            <ul>
                <?php foreach(\Cake\Core\Configure::read('Core.Users.group') as $groupID => $groupName): ?>
                    <li <?php if($pGroupID == $groupID) echo 'class="active"' ?>><?php echo $this->Html->image('System.icon_menu_left.png'); ?><?php echo $this->Html->link($groupName,['controller'=>'menus','action'=>'index',$groupID,$pPluginName]); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div id="right_notfull">
        <?= $this->Flash->render('flash'); ?>
        <div align="right">
            <?php foreach(\Cake\Core\Configure::read('Core.Users.group') as $groupID => $groupName): ?>
                <?php
                if ($groupID != $pGroupID) {
                    echo '<input type = "button" class="btn_large_blue" onclick="location.href=\''.$this->Url->build(['action' => 'copy', '?' => ['model' => 'Menus', 'from_group' => $groupID, 'to_group' => $pGroupID]]).'\'" value="'.__("Copy from {0}", $groupName).'" />';
                }
                ?>
            <?php endforeach; ?>
            <input type = "button" class="btn_small_blue" onclick="location.href='<?php echo $this->Url->build(['action' => 'add', $pGroupID]); ?>';" value="<?php echo __("New menu") ?>" />
        </div>

        <div class="height10"></div>
        <?= $this->Form->create(null, ['action'=>'sort_parent']) ?>
        <table class="tblList" width="100%">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('controller') ?></th>
                    <th><?= $this->Paginator->sort('action') ?></th>
                    <th style="text-align: center"><?= $this->Paginator->sort('display') ?></th>
                    <th style="text-align: center"><?= $this->Paginator->sort('icon') ?></th>
                    <th class="actions" style="text-align: center"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody id="sortable">
                <?php if(isset($menus) && count($menus) > 0): ?>
                    <?php foreach ($menus as $menu): ?>
                        <tr>
                            <td style="font-weight: bold">
                                <input type="hidden" name = "data[Order][]" value="<?= $menu->id ?>" />
                                <?= h($menu->name) ?>
                            </td>
                            <td style="font-weight: bold"><?= h($menu->controller) ?></td>
                            <td style="font-weight: bold"><?= h($menu->action) ?></td>
                            <td style="text-align: center">
                                <?php
                                if($menu->display)
                                    echo $this->Html->link($this->Html->image("System.active.png",array('width' => 12, 'height' => 12)),array('action' => 'set_display',$menu->id,0),array('escape'=>false));
                                else
                                    echo $this->Html->link($this->Html->image("System.lock.png",array('width' => 12, 'height' => 12)),array('action' => 'set_display',$menu->id,1),array('escape'=>false));
                                ?>
                            </td>
                            <td style="text-align: center"><i class="fa <?= $menu->icon?>"></i></td>
                            <td class="actions" style="text-align: center">
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $menu->id]) ?> | 
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $menu->id], ['confirm' => __('Are you sure you want to delete # {0}', $menu->id)]) ?>
                                <?= $this->Html->link(' | '.__('Sort',true) , array('action' => 'sort_child', $menu->id),array('class'=>'sortchild','style'=>'display:none')); ?>
                            </td>
                        </tr>
                        <?php if(isset($menu->Child)):?>
                            <?php foreach($menu->Child as $child):?>
                            <tr class="sort-disabled">
                                <td>&nbsp;&nbsp;<?= h($child->name) ?></td>
                                <td><?= h($child->controller) ?></td>
                                <td><?= h($child->action) ?></td>
                                <td style="text-align: center">
                                    <?php
                                    if($child->display)
                                        echo $this->Html->link($this->Html->image("System.active.png",array('width' => 12, 'height' => 12)),array('action' => 'set_display',$child->id,0),array('escape'=>false));
                                    else
                                        echo $this->Html->link($this->Html->image("System.lock.png",array('width' => 12, 'height' => 12)),array('action' => 'set_display',$child->id,1),array('escape'=>false));
                                    ?>
                                </td>
                                <td style="text-align: center"><i class="fa <?= $child->icon?>"></i></td>
                                <td class="actions" style="text-align: center">
                                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $child->id]) ?> | 
                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $child->id], ['confirm' => __('Are you sure you want to delete # {0}', $child->id)]) ?>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        <?php endif;?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8"><?php echo __('Data is empty') ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <nav class="text-right">
            <ul class="pagination">
                <li>
                    <input id = "btnSubmitSort" type="submit" class="btn_small_blue" value="<?= __('Sort') ?>" style="display:none;" />
                </li>
            </ul>
        </nav>
        <?= $this->Form->end()?>
    </div>
    <!--right end-->
    <div class="cl"></div>
    <div class="height10"></div>
</div>
<script>
    var sortUrl = '<?php echo $this->Url->build(['action' => 'sort_parent']); ?>';
    $(function() {
        $( "#sortable" ).sortable({
            items: ">*:not(.sort-disabled)",
            helper: function (e, ui) {
                ui.children().each(function () {
                    $(this).width($(this).width());
                });
                return ui;
            },
            scroll: true,
            stop: function (event, ui) {
                $("#btnSubmitSort").css('display','inline');
                $(".sort-disabled").hide();
                $(".sortchild").show();
            }
        }).disableSelection();
    });
</script>