<thead>
<tr>
    <?php
    if (!isset($fields) || !$fields) {
        debug('We can not find variable: fields in Element/filter_table.ctp');
        return;
    }
    echo $this->Form->create('Search', [
        'type' => 'get',
        'inputDefaults' => [
            'label' => false
        ]
    ]);
    foreach ($fields as $field => $params) {
        $field = str_replace('.', '*', $field);
        if (isset($params['filter']) && !$params['filter']) {
            echo '<th></th>';
            continue;
        }
        if (!is_array($params)) {
            $field = $params;
        }
        if (!$field) {
            echo '<th></th>';
            continue;
        }
        $paramForm = [
            'class' => 'form-control',
            'label' => false,
            'empty' => '---'.__('Select').'---'
        ];
        //placeholder for input
        $label = isset($params['label'])?$params['label']:__(ucfirst(str_replace('_', ' ', $field)));
        $paramForm['placeholder'] = $label;
        //options for input select
        $options = isset($params['options'])?$params['options']:[];

        if ($options) {
            $paramForm['options'] = $options;
        }
        //hw-select pro
        if (isset($params['hw-select'])) {
            $paramForm['hw-select'] = $params['hw-select'];
        }
        if (isset($params['class'])) {
            $paramForm['class'] .= ' '.$params['class'];
        }
        echo '<th class="hasinput">'.$this->Form->input('S['.$field.']', $paramForm).'</th>';
    }
    ?>
    <th class="hasinput" >
        <button title="<?= __('Filter') ?>" type="submit" class="btn btn-default"><i class="fa fa-filter"></i></button>
        <?php
        $urlHere = $this->request->here(false);
        $urlHere = $url=strtok($urlHere,'?');
        ?>
        <a title="<?= __('Reset') ?>" href="<?php echo $this->Url->build($urlHere); ?>" class="btn btn-default"><i class="fa fa-history"></i></a>
    </th>
    <?php echo $this->Form->end();?>
</tr>
<tr>
    <?php
    foreach ($fields as $field => $params) {
        if (!is_array($params)) {
            $field = $params;
        }
        if (!$field) {
            echo '<th></th>';
            continue;
        }
        $label = isset($params['label'])?$params['label']:__(ucfirst(str_replace('_', ' ', $field)));
        if ((isset($params['sort']) && !$params['sort'])) {
            echo '<th>'.$label.'</th>';
            continue;
        }
        echo '<th class="sorting-custom">'.$this->Paginator->sort($field, $label).'</th>';
    }
    ?>
    <th width="13%"><center><?php echo __('Actions') ?></center></th>
</tr>
</thead>