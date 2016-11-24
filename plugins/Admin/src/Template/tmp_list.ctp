<?php $this->Html->addCrumb(__('System'), '#', array('class' => 'current'));?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-cog fa-fw "></i>
            <?= __('System') ?> <span> &gt; <?= __('List of static pages') ?></span>
        </h1>
    </div>
</div>

<!-- row -->
<div class="row">
    <!-- NEW WIDGET START -->
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <h2><?= __('List of static pages') ?></h2>
            </header>

            <!-- widget div-->
            <div>

                <!-- widget edit box -->
                <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->

                </div>
                <!-- end widget edit box -->

                <!-- widget content -->
                <div class="widget-body no-padding">
                        <table id="datatable_fixed_column" class="table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th class="hasinput">
                                    <input type="text" class="form-control" placeholder="<?= __('Filter title') ?>" />
                                </th>
                                <th class="hasinput">
                                </th>
                            </tr>
                            <tr>
                                <th data-class="expand"><?= __('Title') ?></th>
                                <th width="10%"><?= __('Actions') ?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($pages as $page): ?>
                            <tr>
                                <td><?= h($page->title) ?></td>
                                <td>
                                    <?= $this->Html->link('<i class="fa fa-eye"></i> ', array('action' => 'view', $page->id), array('title' => __('View'),'escape' => false, 'class' => 'btn btn-sm btn-default')); ?>
                                    <?= $this->Html->link('<i class="fa fa-edit"></i> ', array('action' => 'edit', $page->id), array('title' => __('Edit'),'escape' => false, 'class' => 'btn btn-sm btn-default') ); ?>
                                    <?= $this->Form->postLink('<i class="fa fa-trash-o"></i> '.__('Delete'), ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to delete # {0}', $item->id), 'class' => 'btn btn-sm btn-default deleteLin', 'escape' => false]); ?>
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