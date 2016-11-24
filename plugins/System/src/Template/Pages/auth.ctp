<?php
    $pGroupID = $this->request->params['pass'][0];
    $pPluginName = (isset($this->request->params['pass'][1]))?$this->request->params['pass'][1]:null;
?>

<div class="breadscrumb">
    <span><?= __("System") ?></span>
    <?= $this->Html->image('System.brk_center.png') ?>
    <span><?= __("Auth management") ?></span>
        
</div>

<div id="center">
    <div id="left">
        <div class="left_top"><?php echo __('User group') ?></div>
        <div class="content_left">
            <ul>
                <?php foreach(\Cake\Core\Configure::read('Core.Users.group') as $groupID => $groupName): ?>
                <li <?php if($pGroupID == $groupID) echo 'class="active"' ?>><?php echo $this->Html->image('System.icon_menu_left.png'); ?><?php echo $this->Html->link($groupName,['controller'=>'pages','action'=>'auth',$groupID,$pPluginName]); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <div class="hw-10"></div>
        
        <div class="left_top"><?php echo __('Plugins') ?></div>
        <div class="content_left">
            <ul>
                <li <?php if($pPluginName == null) echo 'class="active"' ?>><?php echo $this->Html->image('System.icon_menu_left.png'); ?><?php echo $this->Html->link('--- No Plugin ---',['controller'=>'pages','action'=>'auth',$pGroupID]); ?></li>
                <?php
                $exceptPlugin = ['DebugKit', 'Bake', 'Migrations'];
                foreach($listPlugin as $plugin):
                    if(in_array($plugin, $exceptPlugin)) continue;
                ?>
                <li <?php if($pPluginName == $plugin) echo 'class="active"' ?>><?php echo $this->Html->image('System.icon_menu_left.png'); ?><?php echo $this->Html->link($plugin,['controller'=>'pages','action'=>'auth',$pGroupID,$plugin]); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    <div id="right_notfull">
        <div align="right">
            <?php foreach(\Cake\Core\Configure::read('Core.Users.group') as $groupID => $groupName): ?>
                <?php
                if ($groupID != $pGroupID) {
                    echo '<input type = "button" class="btn_large_blue" onclick="location.href=\''.$this->Url->build(['action' => 'copy', '?' => ['model' => 'UserAuths', 'from_group' => $groupID, 'to_group' => $pGroupID]]).'\'" value="'.__("Copy from {0}", $groupName).'" />';
                }
                ?>
            <?php endforeach; ?>
        </div>
        <br>
        <?= $this->Flash->render('flash'); ?>

        <?= $this->Form->create() ?>
        <table width="100%" class="tblForm">
            <tr>
                <th colspan="3" style="text-align: left">
                    <?= \Cake\Core\Configure::read('Core.Users.group.'.$pGroupID) ?> - 
                    <?= ($pPluginName)?$pPluginName:'App'; ?>
                </th>
            </tr>
            <tr>
                <th style="text-align: left">Public actions</th>
                <th></th>
                <th style="text-align: left">Private actions</th>
            </tr>
            <tr>
                <td width="45%">
                    <select id="lstBox1" name="data[ListPublic][]" size="20" style="width:100%" multiple>
                        <?php foreach($publicActions as $controller => $arrAction): ?>
                        <optgroup label="<?= $controller ?>">
                            <?php foreach($arrAction as $action): ?>
                            <option value="<?= $controller.'-'.$action ?>"><?= $action ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td width="10%" style="text-align: center;vertical-align: middle;">
                    All<input type="checkbox" name="data[CheckAll]" />
                    <div class="hw-10"></div>
                    <button id="btnRight">>></button>
                    <div class="hw-10"></div>
                    <button id="btnLeft"><<</button>
                    <div class="hw-10"></div>
                    <hr />
                    <div class="hw-10"></div>
                    <?= $this->Form->button(__('Save'), ['id' => 'btnSubmit']) ?>
                </td>
                <td width="45%">
                    <select id="lstBox2" name="data[ListPrivate][]" size="20" style="width:100%" multiple>
                        <?php foreach($privateActions as $controller => $arrAction): ?>
                            <optgroup label="<?= $controller ?>">
                                <?php foreach($arrAction as $action): ?>
                                    <option value="<?= $controller.'-'.$action ?>"><?= $action ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table>
        <?= $this->Form->end() ?>
    </div>
    
    <!--right end-->
    <div class="cl"></div>
    <div class="height10"></div>
</div>
<script>
    $(document).ready(function() {
        $("#btnRight, #btnLeft").each(function(){
            $(this).unbind('click').click(function(e){
                var btn = $(this).attr('id');
                var from = '#lstBox1', to = '#lstBox2';
                if(btn == 'btnLeft'){
                    to = '#lstBox1';
                    from = '#lstBox2';
                }
                moveSelected(from, to);
                e.preventDefault();
            })
        });

        $('#btnSubmit').click(function(){
            $('#lstBox2 option').each(function(){
                $(this).attr('selected', true);
            });
            $('#lstBox1 option').each(function(){
                $(this).attr('selected', false);
            });
        })

        function moveSelected(from, to){
            var selectedOpts = $(from+" option:selected");

            if (selectedOpts.length == 0) {
                alert("Nothing to move.");
                return false;
            }
            selectedOpts.each(function(){
                var labelGroup = $(this).parent().attr('label');
                var optGroup = $(to+' > optgroup[label="'+labelGroup+'"]');
                if(optGroup.length == 0) {
                    $(to).append('<optgroup label="'+labelGroup+'"></optgroup>');
                }
                $(this).remove().appendTo(to+' > optgroup[label="'+labelGroup+'"]');
            });
            $(''+from+' > optgroup').each(function(){
                if($(this).find('option').length == 0) {
                    $(this).remove();
                }
            })
        }
    });
</script>