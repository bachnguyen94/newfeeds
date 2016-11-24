<?php use Cake\Core\Configure; ?>
<?php $this->Html->addCrumb(__('System'));?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-cog fa-fw "></i>
            <?= __('System');?>
            <span> > <?= $this->Html->link(__('List of users'), ['action' => 'index'])?></span>
        </h1>
    </div>
</div>

<div class="row">
<!-- NEW WIDGET START -->
<article class="col-sm-12 col-md-12 col-lg-12">

        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                <h2><h2><?= ($user->isNew())?__('User add'):__('User edit'); ?></h2></h2>
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
                                <label class="col-md-2 control-label"><?= __('Email') ?></label>
                                <div class="col-md-9">
                                    <?= $this->Form->input('email', ['disabled' => !$user->isNew() ? true : false, 'class'=>'form-control', 'required' => false, 'placeholder' => __('Email')]); ?>
                                </div>
                            </div>
                            
                            <?php if($user->isNew()):?> <!-- disabled password fields for edit form -->
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?= __('Password') ?></label>
                                <div class="col-md-9"><?= $this->Form->input('password', ['type' => 'password', 'required' => false, 'placeholder' => __('Password'), 'class'=>'form-control']); ?></div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?= __('Confirm password') ?></label>
                                <div class="col-md-9"><?= $this->Form->input('password_confirm', ['type' => 'password', 'required' => false, 'placeholder' => __('Confirm password'), 'class'=>'form-control']); ?></div>
                            </div>
                            <?php endif;?>
                            
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?php echo __('Avatar') ?></label>
                                <div class="col-md-9">
                                    <div class="prevIcon">
                                        <?php
                                        foreach (explode(',', $user->avatar) as $image) {
                                            echo $this->Core->image('Users/'.$image, 64, 64, [], true, false);
                                        }
                                        ?>
                                    </div>

                                    <?= $this->Form->input('avatar', ['preview'=>'.prevIcon','label' => false, 'placeholder' => __('Avatar'), 'class'=>'form-control']); ?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?= __('First name') ?></label>
                                <div class="col-md-4">
                                    <?= $this->Form->input('first_name', ['required' => false, 'placeholder' => __('First name'), 'class'=>'form-control']); ?>
                                </div>

                                <label class="col-md-1 control-label"><?= __('Last name') ?></label>
                                <div class="col-md-4">
                                    <?= $this->Form->input('last_name', ['required' => false, 'placeholder' => __('Last name'), 'class'=>'form-control']); ?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?= __('Group') ?></label>
                                <div class="col-md-4">
                                    <?= $this->Form->input('group', ['hw-select' => true, 'empty' => '--- '.__('Group').' ---', 'type' => 'select', 'options' => Configure::read('Core.Users.group') , 'required' => false, 'class'=>'form-control']); ?>
                                </div>
                                
                                <label class="col-md-1 control-label"><?= __('Active') ?></label>
                                <div class="col-md-4">
                                    <?= $this->Form->checkbox('status', ['class'=>'checkbox', 'label'=>false]); ?>
                                </div>
                            </div>
                        </fieldset>
                    
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-11">
                                    <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
                                    <?= $this->Form->button('<i class="fa fa-save"></i> '.__('Submit'), ['class' => 'btn btn-primary']) ?>
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
<!-- WIDGET END -->
</div>