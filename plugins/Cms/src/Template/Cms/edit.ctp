<?php $this->Html->addCrumb(__('Cms'));?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-cog fa-fw "></i>
            <?= __('Cms');?>
            <span>&gt;
                <?= $this->Html->link(__('List of cms'), ['plugin'=>'admin','action' => 'index',$cms->parent_id])?>
            </span>
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
                <h2><?= _('Edit cms') ?></h2>
            </header>

            <!-- widget div-->
            <div>
                <!-- widget content -->
                <div class="widget-body">
                    <?php $this->loadHelper('Form', ['templates' => 'Admin.bootstrap_form']); ?>
                    <?= $this->Form->create($cms, ['id' => 'smart-form-register', 'class' => 'form-horizontal']) ?>
                        <fieldset>
                            <div class="form-group"></div>
                            
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?= __('Parent') ?></label>
                                <div class="col-md-7">
                                    <?= $this->Form->input('parent_id',['type'=>'select','class'=>'form-control','options'=>$listParent,'empty'=>'--- '.__('Select parent').' ---']) ?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?php echo __('Name') ?></label>
                                <div class="col-md-9"><?= $this->Form->input('name',['class'=>'form-control','required'=>false]) ?></div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?php echo __('Content') ?></label>
                                <div class="col-md-9"><?= $this->Form->input('content',['type'=>'textarea','class'=>'hw-mce-advance','required'=>false]) ?></div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?= __('Url') ?></label>
                                <div class="col-md-7">
                                    <?= $this->Form->input('url', ['class'=>'form-control']) ?>
                                </div>

                                <label class="col-md-1 control-label"><?= __('Popup') ?></label>
                                <div class="col-md-1">
                                    <?= $this->Form->input('url_popup',['type'=>'checkbox','class'=>'checkbox','label'=>false]); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Icon</label>
                                <div class="col-md-9">
                                    <div style="max-width: 64px" class="prevIcon">
                                        <?= $this->Core->image($cms, 'icon', 64,64, [], true,true); ?>
                                    </div>
                                    <?= $this->Form->input('icon', ['class'=>'btn btn-default','preview'=>'.prevIcon']) ?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-2 control-label">Banner</label>
                                <div class="col-md-9">
                                    <div style="max-width: 200px" class="prevBanner">
                                        <?= $this->Core->image($cms, 'banner', 150,100, [], true, true); ?>
                                    </div>
                                    <?= $this->Form->input('banner', ['class'=>'btn btn-default','preview'=>'.prevBanner']) ?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-2 control-label">Active</label>
                                <div class="col-md-9"><?= $this->Form->input('active',['type'=>'checkbox','class'=>'checkbox','label'=>false]); ?></div>
                            </div>
                            
                        </fieldset>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-11">
                                    <?= $this->Html->link(__('Cancel'), ['plugin'=>'admin','action' => 'index',$cms->parent_id], ['class' => 'btn btn-default']) ?>
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