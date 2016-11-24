<div class="breadscrumb">
    <span><?php echo __('Language') ?></span>
    <?= $this->Html->image('System.brk_center.png') ?>
    <span><?php echo __('List of the language') ?></span>
</div>

<div id="center">
    <div id="right">
        <?= $this->Flash->render('flash'); ?>
        <div align="right">
            <ul class="nav nav-tabs">
                <li role="presentation">
                    <?= $this->Html->link(__('Local'), ['action' => 'index']); ?>
                </li>
                <li role="presentation" class="active">
                    <?= $this->Html->link(__('Server'), ['action' => 'server_manager']); ?>
                </li>
                <button class="btn btn-primary" onclick="location.href='<?php echo $this->Url->build(['action' => 'server_add']); ?>';"><?= __('New key')?></button>
            </ul>

        </div>

        <div class="height10"></div>
        <table id="tblList" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <?php foreach ($colTblServer as $field): if($field == 'id') continue; ?>
                    <th width="22%"><?= ucfirst($field) ?></th>
                <?php endforeach;?>
                <th class="actions" style="text-align: center"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($languages) && count($languages) > 0): ?>
                <?php foreach ($languages as $language): ?>
                    <tr>
                        <?php foreach ($colTblServer as $field): if($field == 'id') continue;?>
                            <td><?= h($language[$field]) ?></td>
                        <?php endforeach;?>
                        <td class="actions" style="text-align: center">
                            <?= $this->Html->link(__('Edit'), ['action' => 'server_edit', $language['id']]) ?>
                            <?= $this->Form->postLink('| '.__('Delete'), ['action' => 'server_delete', $language['id']], ['confirm' => __('Are you sure you want to delete # {0}', $language['id'])]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8"><?php echo __('Data is empty') ?></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!--right end-->
    <div class="cl"></div>
    <div class="height10"></div>
</div>
<?php
echo $this->Html->css('//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css');
echo $this->Html->script('//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js');
echo $this->Html->script('//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js');
?>
<script>
    $(document).ready(function(){
        $('#tblList').DataTable();
    });
</script>
<style>
    thead th {
        background-color: #3276b1;
        color: white;
    }
</style>
