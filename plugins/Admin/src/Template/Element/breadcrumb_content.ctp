<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-table fa-fw "></i>
            <?= $this->Html->link($this->request->controller, ['action' => 'index']) ?>
            <span>&gt;
                <?= $this->request->action ?>
            </span>
        </h1>
    </div>
    <?php if($this->request->action != 'add'):?>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
        <ul id="sparks" class="">
            <li class="sparks-info">
                <?= $this->Html->link(__('Add new'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
            </li>
        </ul>
    </div>
    <?php endif;?>
</div>