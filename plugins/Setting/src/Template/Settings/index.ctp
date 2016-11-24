<?php $this->Html->addCrumb(__('System'), '#', array('class' => 'current'));?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-cog fa-fw "></i>
            <?= __('System') ?> <span> > <?php echo __('Settings') ?></span>
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
                <h2><?= __('Update settings') ?></h2>
            </header>

            <!-- widget div-->
            <div>
                <!-- widget content -->
                <div class="widget-body">
                    <?php $this->loadHelper('Form', ['templates' => 'Admin.bootstrap_form']); ?>
                    <?= $this->Form->create($setting,['id' => 'smart-form-register', 'class'=>'form-horizontal']) ?>
                        <fieldset>
                            <div class="form-group"></div>
                            
                            <?php foreach ($stConfig as $field => $value):?>
                                <section>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label"><?php echo __(ucfirst(strtolower(\Cake\Utility\Inflector::humanize($field)))) ?></label>
                                        <div class="col-md-9">
                                            <?php
                                                $class = 'form-control';
                                                $type = $value;
                                                switch ($value) 
                                                {
                                                    case SETTING_TYPE_FILE:
                                                        $class .= ' hw-file';
                                                        break;
                                                    case SETTING_TYPE_RICHTEXTAREA:
                                                        $class .= ' hw-mce-advance';
                                                        $type = 'textarea';
                                                        break;
                                                }
                                            ?>
                                            <?= $this->Form->input($field, ['type' => $type, 'class' => $class, 'required' => false]); ?>
                                        </div>
                                    </div>
                                </section>
                            <?php endforeach;?>
                        </fieldset>
                    
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-11">
                                    <button type="button" class="btn btn-default" onclick="window.history.back();"><?= __('Back') ?></button>
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