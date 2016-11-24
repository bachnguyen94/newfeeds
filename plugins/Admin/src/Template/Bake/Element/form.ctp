<%
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    });
%>
<?php $this->Html->addCrumb(__('<%= $singularHumanName %>'));?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-cog fa-fw "></i>
            <?= __('<%= $singularHumanName %>');?>
            <span>&gt;
                <?= $this->Html->link(__('List of <%= $pluralHumanName %>'), ['action' => 'index'])?>
            </span>
        </h1>
    </div>
</div>

<div class="<%= $pluralVar %> row">
    <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">

        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-sortable jarviswidget-color-darken" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false" role="widget" style="">

            <header role="heading">
                <span class="widget-icon">
                    <i class="fa fa-edit"></i>
                </span>
                <h2><?= __('<%= Inflector::humanize($action) %> <%= $singularHumanName %>') ?></h2>
            </header>

            <!-- widget div-->
            <div role="content">
                <!-- widget content -->
                <div class="widget-body no-padding">
                    <?= $this->Form->create($<%= $singularVar %>, ['id' => 'smart-form-register', 'class' => 'smart-form', ]) ?>
                    <header><?= __('<%= Inflector::humanize($action) %> <%= $singularHumanName %>') ?></header>
                    <fieldset>
<%
                        foreach ($fields as $field) {
                            if (in_array($field, $primaryKey)) {
                                continue;
                            }
%>
                        <section>
<%
                            if (isset($keyFields[$field])) {
                                $fieldData = $schema->column($field);
                                if (!empty($fieldData['null'])) {
%>
                            <?= $this->Form->input('<%= $field %>', ['placeholder' => __('<%= Inflector::humanize($field) %>'), 'options' => $<%= $keyFields[$field] %>, 'empty' => true]); ?>
<%
                                } else {
%>
                            <?= $this->Form->input('<%= $field %>', ['placeholder' => __('<%= Inflector::humanize($field) %>'), 'options' => $<%= $keyFields[$field] %>]) ?>
<%
                                }
                                continue;
                            }
                            if (!in_array($field, ['created', 'modified', 'updated'])) {
                                $fieldData = $schema->column($field);
                                if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) {
%>
                            <?= $this->Form->input('<%= $field %>', ['placeholder' => __('<%= Inflector::humanize($field) %>'), 'empty' => true, 'default' => '']) ?>
<%
                                } else {
%>
                            <?= $this->Form->input('<%= $field %>', ['placeholder' => __('<%= Inflector::humanize($field) %>')]) ?>
<%
                                }
                            }
%>
                        </section>
<%
                        }
                        if (!empty($associations['BelongsToMany'])) {
                            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
%>
                        <section>
                            <?= $this->Form->input('<%= $assocData['property'] %>._ids', ['placeholder' => __('<%= $field %>'), 'options' => $<%= $assocData['variable'] %>]) ?>
                        </section>
<%
                            }
                        }
%>
                    </fieldset>

                    <footer>
                        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
                        <?= $this->Html->link('cancel', ['action' => 'index'], ['class' => 'btn btn-default']) ?>
                    </footer>
                    <?= $this->Form->end() ?>

                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
        <!-- end widget -->
    </article>
</div>
