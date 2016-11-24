<%
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    });
%>
<?php $this->Html->addCrumb(__('<%= $singularHumanName %>'));?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-9">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-cog fa-fw "></i>
            <?= __('<%= $singularHumanName %>');?>
            <span> > 
                <?= $this->Html->link(__('List of <%= strtolower($pluralHumanName) %>'), ['plugin'=>'admin','action' => 'index'])?>
            </span>
        </h1>
    </div>
</div>


<div class="row">
				
<!-- NEW WIDGET START -->
<article class="col-sm-12 col-md-12 col-lg-12">

        <!-- Widget ID (each widget will need unique ID)-->
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                <h2><?= ($<%= $singularVar %>->isNew())?__('<%= $singularHumanName %> add'):__('<%= $singularHumanName %> edit') ?></h2>
            </header>

            <!-- widget div-->
            <div>
                <!-- widget content -->
                <div class="widget-body">
                    <?php $this->loadHelper('Form', ['templates' => 'Admin.bootstrap_form']); ?>
                    <?= $this->Form->create($<%= $singularVar %>, ['id' => 'smart-form-register', 'class' => 'form-horizontal']) ?>
                        <fieldset>
                            <div class="form-group"></div>
                            
<%
                        foreach ($fields as $field) 
                        {
                            if (in_array($field, $primaryKey)) {continue;}
%>
                            <div class="form-group">
<%
                            if (isset($keyFields[$field])) 
                            {
%>
                                <label class="col-md-2 control-label"><%= "<?= __('".ucfirst(strtolower(Inflector::humanize($field)))."') ?>" %></label>
                                <div class="col-md-9">
<%
                                $fieldData = $schema->column($field);
                                if (!empty($fieldData['null'])) 
                                {
%>
                                <?= $this->Form->input('<%= $field %>', ['placeholder' => __('<%= Inflector::humanize($field) %>'),'class'=>'form-control', 'options' => $<%= $keyFields[$field] %>, 'empty' => true]); ?>
<%
                                } else 
                                {
%>
                                <?= $this->Form->input('<%= $field %>', ['placeholder' => __('<%= Inflector::humanize($field) %>'),'class'=>'form-control', 'options' => $<%= $keyFields[$field] %>]) ?>
<%
                                }
%>
                                </div>
<%
%>
                                </div>
<%
                                continue;
                            }
                            
                            if (!in_array($field, ['created', 'modified', 'updated'])) 
                            {
                                $fieldData = $schema->column($field);
                                if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) 
                                {
%>
                                <?= $this->Form->input('<%= $field %>', ['placeholder' => __('<%= Inflector::humanize($field) %>'), 'empty' => true, 'default' => '']) ?>
<%
                                } else 
                                {
%>
                                <label class="col-md-2 control-label"><%= "<?= __('".ucfirst(strtolower(Inflector::humanize($field)))."') ?>" %></label>
                                <div class="col-md-9">
<%  
                                    if ($fieldData['type'] === 'boolean')
                                    {
%>
                                        <?= $this->Form->input('<%= $field %>', ['class'=>'checkbox','label'=>false]) ?>
<%  
                                    }
                                    else if($fieldData['type'] === 'text' && $field == 'content')
                                    {
%>
                                        <?= $this->Form->input('<%= $field %>', ['class'=>'hw-mce-advance','required'=>false]) ?>
<%
                                    }
                                    else
                                    {
%>
                                        <?= $this->Form->input('<%= $field %>', ['placeholder' => __('<%= ucfirst(strtolower(Inflector::humanize($field))) %>'),'class'=>'form-control']) ?>
<%
                                    }
%>
                            </div>
<%
                                }
                            }
%>
                            </div>
<%
                        }
                        if (!empty($associations['BelongsToMany'])) {
                            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
%>
                                <?= $this->Form->input('<%= $assocData['property'] %>._ids', ['placeholder' => __('<%= $field %>'), 'options' => $<%= $assocData['variable'] %>]) ?>
<%
                            }
                        }
%>
                        </fieldset>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-11">
                                    <?= $this->Html->link(__('Cancel'), ['plugin'=>'admin','action' => 'index'], ['class' => 'btn btn-default']) ?>
                                    <?= $this->Form->button('<i class="fa fa-save"></i> '.__('Submit'), ['class' => 'btn btn-primary']) ?>
                                </div>
                            </div>
                        </div>
                    <?= $this->Form->end() ?>
                </div>
                <!-- end widget content -->
            </div>
            <!-- end widget div -->
        </div>
        <!-- end widget -->
</article>
<!-- WIDGET END -->
</div>
