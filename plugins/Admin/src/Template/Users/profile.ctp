<?php use Cake\Core\Configure; ?>
<?php $this->Html->addCrumb(__('Account'));?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-user-md"></i>
            <?= __('Account');?>
            <span>&gt; <?= __('My profile')?></span>
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
                <h2><?= __('Edit profile')?></h2>
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
                            <label class="col-md-2 control-label"><?= __('Email') ?> <span class="required">(*)</span></label>
                            <div class="col-md-9">
                                <?= $this->Form->input('email', ['disabled' => true, 'class'=>'form-control', 'required' => false, 'placeholder' => __('Email')]); ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label"><?= __('First name') ?> <span class="required"></span></label>
                            <div class="col-md-9">
                                <?= $this->Form->input('first_name', ['required' => false, 'placeholder' => __('First name'),'class'=>'form-control']); ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label"><?= __('Last name') ?> <span class="required"></span></label>
                            <div class="col-md-9">
                                <?= $this->Form->input('last_name', ['required' => false, 'placeholder' => __('Last name'),'class'=>'form-control']); ?>
                            </div>
                        </div>
                    </fieldset>
                    
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-11">
                                <?= $this->Form->button('<i class="fa fa-save"></i> '.__('Save'), ['class' => 'btn btn-primary']) ?>
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