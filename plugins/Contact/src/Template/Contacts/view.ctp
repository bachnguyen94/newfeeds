
<?php $this->Html->addCrumb(__('System'));?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-credit-card"></i>
            <?= __('Contact');?>
            <span>&gt;
                <?= $this->Html->link(__('List of contacts'), ['action' => 'index'])?>
            </span>
        </h1>
    </div>
</div>

<div class="row">
    <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-sortable jarviswidget-color-darken" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">
            <header role="heading">
                <span class="widget-icon">
                    <i class="fa fa-edit"></i>
                </span>
                <h2><?= h($contact->name) ?></h2>
            </header>
            <!-- widget div-->
            <div role="content">
                <!-- widget edit box -->
                <div class="jarviswidget-editbox">
                    <!-- This area used as dropdown edit box -->
                </div>
                <!-- end widget edit box -->
                <!-- widget content -->
                <div class="widget-body">
                    <fieldset>
                        <table id="user" class="table table-bordered table-striped" style="clear: both">
                            <tbody>
                                <tr>
                                    <td style="width:35%;"><?= __('Contact name') ?></td>
                                    <td style="width:65%"><?= h($contact->name) ?></td>
                                </tr>
                                <tr>
                                    <td style="width:35%;"><?= __('Email') ?></td>
                                    <td style="width:65%"><a href="mailto:<?= h($contact->email) ?>"><?= h($contact->email) ?></a></td>
                                </tr>
                                <tr>
                                    <td style="width:35%;"><?= __('Phone') ?></td>
                                    <td style="width:65%"><?= h($contact->phone) ?></td>
                                </tr>
                                <tr>
                                    <td style="width:35%;"><?= __('Address') ?></td>
                                    <td style="width:65%"><?= h($contact->address) ?></td>
                                </tr>
                                <tr>
                                    <td style="width:35%;"><?= __('Content') ?></td>
                                    <td style="width:65%"><?= h($contact->content) ?></td>
                                </tr>
                                <tr>
                                    <td style="width:35%;"><?= __('Created') ?></td>
                                    <td style="width:65%"><?= $this->Core->datetime($contact->created) ?></td>
                                </tr>
                                <tr>
                                    <td style="width:35%;"><?= __('IP') ?></td>
                                    <td style="width:65%"><?= $contact->ip ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </fieldset>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12">
                                <?= $this->Html->link(__('Back'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contact->id], ['title' => __('Delete'), 'data-action' => 'deleteLin', 'data-delete-msg' => __('Are you sure you want to delete # {0}', $contact->id), 'class' => 'btn btn-sm btn-primary deleteLin', 'escape' => false]) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end widget content -->
            </div>
            <!-- end widget div -->
        </div>
        <!-- end widget -->
    </article>
</div>
