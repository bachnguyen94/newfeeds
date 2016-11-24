<?php if(isset($list)): ?>
<?php foreach($list as $item): ?>
<div style="margin-bottom: 5px;background-color:yellow;">
<?= $item->controller ?>    
</div>
<?php endforeach; ?>
<?php endif; ?>