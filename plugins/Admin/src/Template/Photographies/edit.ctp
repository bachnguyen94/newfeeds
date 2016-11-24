<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $photography->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $photography->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Photographies'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="photographies form large-9 medium-8 columns content">
    <?= $this->Form->create($photography) ?>
    <fieldset>
        <legend><?= __('Edit Photography') ?></legend>
        <?php
            echo $this->Form->input('imageUrl');
            echo $this->Form->input('title');
            echo $this->Form->input('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
