<?php
    $parentID = (isset($this->request->params['pass'][0]))?$this->request->params['pass'][0]:null;
    $this->Html->addCrumb(__('Cms')); 
?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-cog fa-fw "></i>
            <?= __('Cms');?>
            <span> > <?= __('List of cms')?></span>
        </h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
        <ul id="sparks" class="">
            <li class="sparks-info">
                <?= $this->Html->link(__('New cms'), ['plugin'=>'admin','action' => 'add',$parentID], ['class' => 'btn btn-primary']) ?>
            </li>
        </ul>
    </div>
</div>

<div class="row">
    <!-- NEW WIDGET START -->
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="true">
            <header>
                <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                <h2><?= __('List of cms')?></h2>
            </header>
            <!-- widget div-->
            <div>
                <!-- widget edit box -->
                <div class="jarviswidget-editbox">
                    <!-- This area used as dropdown edit box -->
                </div>
                <!-- end widget edit box -->
                <!-- widget content -->
                <div class="widget-body">
                    
                    <?php echo $this->element('breadcrumb') ?>
                    
                    <table id="datatable_fixed_column" class="table table-striped table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th class="hasinput"><input type="text" class="form-control" placeholder="Name" /></th>
                            <th class="hasinput"></th>
                            <th class="hasinput"></th>
                        </tr>
                        <tr>
                            <th><?= __('Name') ?></th>
                            <th width="10%"><?= __('Active') ?></th>
                            <th width="13%"><?php echo __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody class="hw-sort">
                        <?php foreach($cms as $item): ?>
                            <tr data-id="<?= $item->id ?>">
                                <td>
                                    <?= $this->Html->link($item->name,['action'=>'index',$item->id]) ?>
                                    <?= (count($item->children)>0)?'('.count($item->children).')':''; ?>
                                </td>
                                <td><center><?= $this->Core->active($item, 'active')?></center></td>
                                <td>
                                    <center>
                                        <?= $this->Html->link('<i class="fa fa-eye"></i> ', ['action' => 'view', $item->id], ['title' => __('View'), 'escape' => false, 'class' => 'btn btn-sm btn-default']);?>
                                        <?= $this->Html->link('<i class="fa fa-edit"></i> ', ['action' => 'edit', $item->id], ['title' => __('Edit'), 'escape' => false, 'class' => 'btn btn-sm btn-default']); ?>
                                        <?= $this->Form->postLink('<i class="fa fa-trash-o"></i> ', ['action' => 'delete', $item->id], ['title' => __('Delete'), 'data-action' => 'deleteLin', 'data-delete-msg' => __('Are you sure you want to delete # {0}', $item->id), 'class' => 'btn btn-sm btn-default deleteLin', 'escape' => false]) ?>
                                    </center>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>
                <!-- end widget content -->
            </div>
            <!-- end widget div -->
        </div>
        <!-- end widget -->
    </article>
    <!-- WIDGET END -->
</div>