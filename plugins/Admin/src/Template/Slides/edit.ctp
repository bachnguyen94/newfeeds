<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $slide->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $slide->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Slides'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="slides form large-9 medium-8 columns content">
    <?= $this->Form->create($slide) ?>
    <fieldset>
        <legend><?= __('Edit Slide') ?></legend>
        <?php
            echo $this->Form->input('table_name');
            echo $this->Form->input('record_id');
            echo $this->Form->input('display_order');
            echo $this->Form->input('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
