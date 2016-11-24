<div class="row">
    <div class="col-sm-6 col-xs-12">
        <?php if (!isset($showing)|| $showing):?>
        <div class="dataTables_info" id="datatable_fixed_column_info" role="status" aria-live="polite">
            <?= $this->Paginator->counter(__('Showing <span class="txt-color-darken">{{start}}</span> to <span class="txt-color-darken">{{end}}</span> of <span class="txt-color-darken">{{count}}</span> entries')); ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="col-sm-6 col-xs-12">
        <ul class="pagination pagination-sm pull-right">
            <?php
                if ($this->Paginator->hasPrev()) {
                    echo $this->Paginator->prev(__('Previous'));
                }
            ?>
            <?= $this->Paginator->numbers(); ?>
            <?php
                if ($this->Paginator->hasNext()) {
                    echo $this->Paginator->next(__('Next'));
                }
            ?>
        </ul>
    </div>
</div>