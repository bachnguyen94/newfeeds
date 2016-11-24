<?php $this->Html->addCrumb(__('System')); ?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-credit-card"></i>
            <?= __('Contact');?>
            <span>&gt;
                <?= __('List of contacts')?>
            </span>
        </h1>
    </div>
</div>

<div class="row">
    <!-- NEW WIDGET START -->
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-editbutton="true">
            <header>
                <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                <h2><?= __('List of contacts')?></h2>
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
                            <th class="hasinput"><input type="text" class="form-control" placeholder="<?= __('Filter') ?> <?= __('Name') ?>" /></th>
                            <th class="hasinput"><input type="text" class="form-control" placeholder="<?= __('Filter') ?> <?= __('Email') ?>" /></th>
                            <th class="hasinput"><input type="text" class="form-control" placeholder="<?= __('Filter') ?> <?= __('Phone') ?>" /></th>
                            <th class="hasinput"><input type="text" class="form-control" placeholder="<?= __('Filter') ?> <?= __('Created') ?>" /></th>
                            <th class="hasinput" ></th>
                        </tr>
                        <tr>
                            <th><?= __('Contact name') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th width="13%"><?= __('Created') ?></th>
                            <th width="13%"><?php echo __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $contact): ?>
                            <tr <?php if($contact->read) echo 'style="background-color:#EFF1F2"'; ?>>
                                <td><?= h($contact->name) ?></td>
                                <td><a href="mailto:<?= h($contact->email) ?>"><?= h($contact->email) ?></a></td>
                                <td><?= h($contact->phone) ?></td>
                                <td><?= $this->Core->datetime($contact->created) ?></td>
                                <td>
                                    <center>
                                    <?= $this->Html->link('<i class="fa fa-eye"></i> ', ['action' => 'view', $contact->id], ['title' => __('View'), 'escape' => false, 'class' => 'btn btn-sm btn-default']);?>
                                    <?= $this->Form->postLink('<i class="fa fa-trash-o"></i> ', ['action' => 'delete', $contact->id], ['title' => __('Delete'), 'data-action' => 'deleteLin', 'data-delete-msg' => __('Are you sure you want to delete # {0}', $contact->id), 'class' => 'btn btn-sm btn-default deleteLin', 'escape' => false]) ?>
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
