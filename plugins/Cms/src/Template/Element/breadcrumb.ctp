<?php if(isset($crumbs)): ?>
<p>
    <?= $this->Html->link(__('Top'),['action'=>'index']) ?>
    <?php foreach($crumbs as $item): ?>
    > <?= $this->Html->link($item->name,['action'=>'index',$item->id]) ?>
    <?php endforeach;; ?>
</p>
<?php endif; ?>