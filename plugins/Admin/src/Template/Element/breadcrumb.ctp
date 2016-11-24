<!-- RIBBON -->
<div id="ribbon">
    <span class="ribbon-button-alignment">
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> <?= __('Warning this will reset your pages')?>" data-html="true">
            <i class="fa fa-refresh"></i>
        </span>
    </span>
    <!-- breadcrumb -->
    <?php
        echo $this->Html->getCrumbList(
            [
                'firstClass' => false,
                'lastClass' => 'active',
                'class' => 'breadcrumb',
            ],
            [
                'text' => 'Dashboard',
                'url' => ['plugin'=>'Admin','controller' => 'users', 'action' => 'profile']
            ]
        );
    ?>
<!--    <span class="ribbon-button-alignment pull-right">-->
<!--        <span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>-->
<!--        <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>-->
<!--        <span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>-->
<!--    </span>-->
</div>
<!-- END RIBBON -->