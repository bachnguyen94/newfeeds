<?php $this->Html->addCrumb(__('System'), '#', array('class' => 'current'));?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-cog fa-fw "></i>
            <?= __('System') ?> <span> &gt; <?= $this->Html->link(__('List of static pages'), ['action' => 'index']) ?></span>
        </h1>
    </div>
</div>
<div class="row">
    <!-- NEW COL START -->
    <article class="col-sm-12 col-md-12 col-lg-12">
        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
            <header>
                    <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                    <h2><?= __('Edit static page') ?></h2>
            </header>
            <!-- widget div-->
            <div>
                <!-- widget content -->
                <div class="widget-body no-padding">
                    <?= $this->Form->create($page,['class'=>'smart-form']) ?>
                        <fieldset>
                            <section>
                                <label class="label"><?php echo __('Title') ?></label>
                                <label class="input">
                                    <?= $this->Form->input('title',['label'=>false,'required'=>false]); ?>
                                </label>
                            </section>
                            <section>
                                <label class="label"><?php echo __('Content') ?></label>
                                <label class="input">
                                    <?= $this->Form->input('content',['type'=>'text','class'=>'hw-mce-advance','label'=>false,'required'=>false]); ?>
                                </label>
                            </section>
                        </fieldset>

                        <footer>
                            <button type="submit" class="btn btn-primary"><?= __('Submit') ?></button>
                            <button type="button" class="btn btn-default" onclick="window.history.back();"><?= __('Back') ?></button>
                        </footer>
                    <?= $this->Form->end() ?>
                </div>
                <!-- end widget content -->
            </div>
            <!-- end widget div -->
        </div>
        <!-- end widget -->
    </article>
    <!-- END COL -->
</div>