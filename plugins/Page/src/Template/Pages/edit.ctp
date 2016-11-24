<?php $this->Html->addCrumb(__('System'));?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-cog fa-fw "></i>
            <?= __('System') ?> <span> > <?= $this->Html->link(__('List of static pages'), ['action' => 'index']) ?></span>
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
                <h2><?= __('Edit static page') ?></h2>
            </header>

            <!-- widget div-->
            <div>
                <!-- widget content -->
                <div class="widget-body">
                    <?php $this->loadHelper('Form', ['templates' => 'Admin.bootstrap_form']); ?>
                    <?= $this->Form->create($page,['class' => 'form-horizontal']) ?>
                        <fieldset>
                            <div class="form-group"></div>
                            
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?php echo __('Title') ?></label>
                                <div class="col-md-9"><?= $this->Form->input('title',['class'=>'form-control', 'required'=>false]); ?></div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-2 control-label"><?php echo __('Content') ?></label>
                                <div class="col-md-9"><?= $this->Form->input('content',['type'=>'textarea','class'=>'hw-mce-advance','required'=>false]); ?></div>
                            </div>
                            
                        </fieldset>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-11">
                                    <?= $this->Html->link(__('Cancel'), ['plugin'=>'admin','action' => 'index'], ['class' => 'btn btn-default']) ?>
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