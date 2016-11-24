<div class="breadscrumb">
    <span><?php echo __("Language") ?></span>
    <?= $this->Html->image('System.brk_center.png') ?>
    <span><?php echo __("List of the language") ?></span>
</div>

<div id="center">
    <div id="right">
        <?= $this->Flash->render('flash'); ?>
            <div align="right" style="border-bottom: 1px dashed; padding-bottom: 5px;">
                <button class="btn btn-success" onclick="document.formImport.submit();event.returnValue = false; return false;"><?= __('Import')?></button>
                <button class="btn btn-default" onclick="location.href='<?php echo $this->Url->build(['action' => 'index']); ?>';"><?= __('Back')?></button>
            </div>

        <?= $this->Form->create(null, ['name' => 'formImport']) ?>

        <div class="height10"></div>
        <table id="tblList" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th><?= __('Key') ?></th>
                <th><?= __('English') ?></th>
                <th><?= __('Vietnamese') ?></th>
                <th><?= __('Japanese') ?></th>
                <th width="10%" class="actions" style="text-align: center"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($languages) && count($languages) > 0): ?>
                <?php foreach ($languages as $language): ?>
                    <tr>
                        <td><?= h($language['key']) ?></td>
                        <td><?= h($language['eng']) ?></td>
                        <td><?= h($language['vie']) ?></td>
                        <td><?= h($language['jpn']) ?></td>
                        <td class="actions" style="text-align: center">
                            <?= $this->Html->link(__('Edit'), ['action' => 'add', $language['id']]) ?>
                            <?= $this->Form->postLink('| '.__('Delete'), ['action' => 'delete', $language['id']], ['confirm' => __('Are you sure you want to delete # {0}', $language['id'])]) ?>
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
        <?= $this->Form->end()?>
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
        if ( $('#tblList tbody td').length > 1 ) {
            $('#tblList').DataTable({
                "oLanguage": {
                    "sEmptyTable" : "Your custom message for empty table"
                }
            });
        }
    });
</script>
<style>
    thead th {
        background-color: #929191;
        color: white;
    }
</style>