<?php use Cake\Core\Configure; ?>
<?php $this->Html->addCrumb(__('System'));?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-cog fa-fw "></i>
            <?= __('System');?>
            <span> > <?= $this->Html->link(__('List of photography'), ['action' => 'index'])?></span>
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
                <h2><h2><?= ($photography->isNew())?__('photography add'):__('photography edit'); ?></h2></h2>
            </header>

            <!-- widget div-->
            <div>
                <!-- widget content -->
                <div class="widget-body">
                    <?php $this->loadHelper('Form', ['templates' => 'Admin.bootstrap_form']); ?>
                    <?= $this->Form->create($photography, ['id' => 'smart-form-register', 'class' => 'form-horizontal']) ?>
                    <fieldset>
                        <div class="form-group"></div>

                        <div class="form-group">
                            <label class="col-md-2 control-label"><?= __('Title') ?><span class="textred"> (*)</span></label>
                            <div class="col-md-9">
                                <?= $this->Form->input('title', ['required' => true, 'class'=>'form-control', 'required' => false, 'placeholder' => __('Title')]); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label"><?= __('Description') ?></label>
                            <div class="col-md-9">
                                <?= $this->Form->input('description', ['class'=>'form-control', 'required' => false, 'placeholder' => __('Description')]); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label"><?php echo __('Image') ?></label>
                            <div class="col-md-9">
                                <div class="prevIcon">
                                    <?php
                                    foreach (explode(',', $photography->imageUrl) as $image) {
                                        echo $this->Core->image('Photographies/'.$image, 64, 64, [], true, false);
                                    }
                                    ?>
                                </div>

                                <?= $this->Form->input('imageUrl', [
                                    'type' => 'file',
                                    'preview'=>'.prevIcon',
                                    'label' => false,
                                    'placeholder' => __('Avatar'), 'class'=>'form-control hw-file']); ?>
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