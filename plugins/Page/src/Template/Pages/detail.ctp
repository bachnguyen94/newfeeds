
<font color="red">Hey dev: copy the front-end design here.</font>

<hr />

<?php if($page): ?>

<?= $page->title ?>
<hr />
<?= $page->content ?>

<?php else: ?>
<?= __('This page does not exist') ?>
<?php endif; ?>