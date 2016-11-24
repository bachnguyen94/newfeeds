<div class="row">
    <div class="col-sm-8 nopadding">
        <ul class="pagination pagination-sm">
            <?php
            if(isset($params)){
                $this->Paginator->options(array('url' => array('?'=>$params)));
            }

            echo '<li>' .$this->Paginator->first('< '.__('First')).'</li>';
            echo '<li>' . $this->Paginator->prev(__('Prev')) .'</li>';
            echo $this->Paginator->numbers(array(
                'separator' => '',
                'tag' => 'li',
                'currentClass' => 'active',
                'currentTag' => 'span'
            ));
            echo '<li>'.$this->Paginator->next(__('Next')).'</li>';
            echo '<li>' .$this->Paginator->last(__('Last').' >').'</li>';

            ?>
        </ul>
    </div>
    <?php if (!isset($add) || $add): ?>
        <div class="col-sm-4 text-right nopadding">
            <?php
            echo $this->Html->link(__('Add new'), array('action' => 'add'), array('class' => 'btn btn-info btn-sm'))
            ?>
        </div>
    <?php endif; ?>
    <?php if (isset($deleteAll) && $deleteAll): ?>
        <div class="col-sm-4 text-right nopadding">
            <?php
            echo $this->Form->submit(__('Delete selected'), array('class' => 'btn btn-sm btn-default deleteLink disableLink'));
            ?>
        </div>
    <?php endif; ?>
    <?php if (isset($submitEdit) && $submitEdit): ?>
        <div class="col-sm-4 text-right nopadding">
            <?php
            echo $this->Html->link(__('Back to translate'), array('action' => 'translate'), array('class' => 'btn btn-sm btn-info')). ' ';
            echo $this->Form->submit(__('Save data'), array('class' => 'btn btn-sm btn-default', 'div' => false));
            ?>
        </div>
    <?php endif; ?>
</div>