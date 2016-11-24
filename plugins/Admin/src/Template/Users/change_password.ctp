<?php use Cake\Core\Configure; ?>
<?php $this->Html->addCrumb(__('Account'));?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-user-md"></i>
            <?= __('Account');?>
            <span>&gt; <?= __('Change password')?></span>
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
                <h2><?= __('Change password')?></h2>
            </header>

            <!-- widget div-->
            <div>
                <!-- widget content -->
                <div class="widget-body">
                    <?php $this->loadHelper('Form', ['templates' => 'Admin.bootstrap_form']); ?>
                    <?= $this->Form->create($user, ['id' => 'smart-form-register', 'class' => 'form-horizontal']) ?>

                    <fieldset>
                        <div class="form-group"></div>

                        <div class="form-group">
                            <label class="col-md-2 control-label"><?= __('Old password') ?> <span class="required">(*)</span></label>
                            <div class="col-md-9">
                                <?= $this->Form->input('old_password', ['type' => 'password', 'required' => false, 'placeholder' => __('Old password'),'class'=>'form-control']); ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label"><?= __('New password') ?> <span class="required">(*)</span></label>
                            <div class="col-md-9">
                                <?= $this->Form->input('new_password', ['type' => 'password', 'required' => false, 'placeholder' => __('New password'),'class'=>'form-control']); ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label"><?= __('Password confirm') ?> <span class="required">(*)</span></label>
                            <div class="col-md-9">
                                <?= $this->Form->input('new_password_confirm', ['type' => 'password', 'required' => false, 'placeholder' => __('Password confirm'),'class'=>'form-control']); ?>
                            </div>
                        </div>
                    </fieldset>
                    
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-11">
                                <?= $this->Form->button('<i class="fa fa-save"></i> '.__('Change'), ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>
                    </div>
                    <?= $this->Form->end() ?>

                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
        <!-- end widget -->
    </article>
</div>