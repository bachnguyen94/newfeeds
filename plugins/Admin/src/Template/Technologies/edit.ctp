<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $technology->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $technology->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Technologies'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="technologies form large-9 medium-8 columns content">
    <?= $this->Form->create($technology) ?>
    <fieldset>
        <legend><?= __('Edit Technology') ?></legend>
        <?php
            echo $this->Form->input('imageUrl');
            echo $this->Form->input('title');
            echo $this->Form->input('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
