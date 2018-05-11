<?php
namespace UpStream\Frontend;

function arrayToAttrs($data)
{
    $attrs = array();

    foreach ($data as $attrKey => $attrValue) {
        $attrs[] = sprintf('%s="%s"', $attrKey, esc_attr($attrValue));
    }

    return implode(' ', $attrs);
}

function getMilestonesFields($areCommentsEnabled = null)
{
    $milestones = getMilestonesTitles();

    $schema = array(
        'milestone'   => array(
            'type'        => 'custom',
            'isOrderable' => true,
            'label'       => upstream_milestone_label(),
            'renderCallback' => function($columnName, $columnValue, $column, $row, $rowType, $projectId) use (&$milestones) {
                $milestone = !isset($milestones[$columnValue])
                    ? '<span title="'. __("This Milestone doesn't exist anymore.", 'upstream') .'">'. $columnValue .' <small><i class="fa fa-ban"></i></small></span>'
                    : $milestones[$columnValue];

                return $milestone;
            }
        ),
        'assigned_to' => array(
            'type'        => 'user',
            'isOrderable' => true,
            'label'       => __('Assigned To', 'upstream')
        ),
        'tasks'       => array(
            'type'  => 'custom',
            'label' => upstream_task_label_plural(),
            'isEditable' => false,
            'renderCallback' => function($columnName, $columnValue, $column, $row, $rowType, $projectId) {
                $tasksOpenCount = isset($row['task_open']) ? (int)$row['task_open'] : 0;
                $tasksCount = isset($row['task_count']) ? (int)$row['task_count'] : 0;

                return sprintf(
                    '%d %s / %d %s',
                    $tasksOpenCount,
                    _x('Open', 'Open Tasks', 'upstream'),
                    $tasksCount,
                    _x('Total', 'Total number of Tasks', 'upstream')
                );
            }
        ),
        'progress'    => array(
            'type'        => 'percentage',
            'isOrderable' => true,
            'label'       => __('Progress', 'upstream'),
            'isEditable'  => false
        ),
        'start_date'  => array(
            'type'        => 'date',
            'isOrderable' => true,
            'label'       => __('Start Date', 'upstream')
        ),
        'end_date'    => array(
            'type'        => 'date',
            'isOrderable' => true,
            'label'       => __('End Date', 'upstream')
        ),
        'notes'       => array(
            'type'     => 'wysiwyg',
            'label'    => __('Notes', 'upstream'),
            'isHidden' => true
        ),
        'comments'    => array(
            'type'       => 'comments',
            'label'      => __('Comments'),
            'isHidden'   => true,
            'isEditable' => false
        )
    );

    if ($areCommentsEnabled === null) {
        $areCommentsEnabled = upstreamAreCommentsEnabledOnMilestones();
    }

    if (!$areCommentsEnabled) {
        unset($schema['comments']);
    }

    return apply_filters('upstream:project.milestones.fields', $schema);
}

function getTasksFields($statuses = array(), $milestones = array(), $areMilestonesEnabled = null, $areCommentsEnabled = null)
{
    if ($areMilestonesEnabled === null) {
        $areMilestonesEnabled = !upstream_are_milestones_disabled() && !upstream_disable_milestones();
    }

    $statuses = empty($statuses) ? getTasksStatuses() : $statuses;
    $options = array();

    $schema = array(
        'title' => array(
            'type'        => 'raw',
            'isOrderable' => true,
            'label'       => __('Title', 'upstream')
        ),
        'assigned_to' => array(
            'type'        => 'user',
            'isOrderable' => true,
            'label'       => __('Assigned To', 'upstream')
        ),
        'status'       => array(
            'type'  => 'custom',
            'label' => __('Status', 'upstream'),
            'renderCallback' => function($columnName, $columnValue, $column, $row, $rowType, $projectId) use (&$statuses, &$options) {
                if (strlen($columnValue) > 0) {
                    if (isset($statuses[$columnValue])) {
                        $columnValue = sprintf('<span class="label up-o-label" style="background-color: %s;">%s</span>', $statuses[$columnValue]['color'], $statuses[$columnValue]['name']);
                    } else {
                        $columnValue = sprintf(
                            '<span class="label up-o-label" title="%s" style="background-color: %s;">%s <i class="fa fa-ban"></i></span>',
                            __("This Status doesn't exist anymore.", 'upstream'),
                            '#bdc3c7',
                            $columnValue
                        );
                    }
                } else {
                    $columnValue = sprintf('<i class="s-text-color-gray">%s</i>', __('none', 'upstream'));
                }

                return $columnValue;
            }
        ),
        'progress'    => array(
            'type'        => 'percentage',
            'isOrderable' => true,
            'label'       => __('Progress', 'upstream')
        ),
        'milestone'   => array(
            'type'        => 'custom',
            'isOrderable' => true,
            'label'       => upstream_milestone_label(),
            'renderCallback' => function($columnName, $columnValue, $column, $row, $rowType, $projectId) use (&$milestones) {
                if (strlen($columnValue) > 0) {
                    if ($milestones === null) {
                        $milestones = array();
                        $meta = (array)get_post_meta(upstream_post_id(), '_upstream_project_milestones', true);
                        foreach ($meta as $data) {
                            if (!isset($data['id'])
                                || !isset($data['created_by'])
                                || !isset($data['milestone'])
                            ) {
                                continue;
                            }

                            $milestones[$data['id']] = array(
                                'title' => $data['milestone'],
                                'color' => $milestonesColors[$data['milestone']],
                                'id'    => $data['id']
                            );
                        }
                    }

                    if (isset($milestones[$columnValue])) {
                        $columnValue = sprintf('<span class="label up-o-label" style="background-color: %s;">%s</span>', $milestones[$columnValue]['color'], $milestones[$columnValue]['title']);
                    } else {
                        $columnValue = sprintf(
                            '<span class="label up-o-label" title="%s" style="background-color: %s;">%s <i class="fa fa-ban"></i></span>',
                            __("This Milestone doesn't exist anymore.", 'upstream'),
                            '#bdc3c7',
                            $columnValue
                        );
                    }
                } else {
                    $columnValue = sprintf('<i class="s-text-color-gray">%s</i>', __('none', 'upstream'));
                }

                return $columnValue;
            }
        ),
        'start_date'  => array(
            'type'        => 'date',
            'isOrderable' => true,
            'label'       => __('Start Date', 'upstream')
        ),
        'end_date'    => array(
            'type'        => 'date',
            'isOrderable' => true,
            'label'       => __('End Date', 'upstream')
        ),
        'notes'       => array(
            'type'     => 'wysiwyg',
            'label'    => __('Notes', 'upstream'),
            'isHidden' => true
        ),
        'comments'    => array(
            'type'     => 'comments',
            'label'    => __('Comments'),
            'isHidden' => true,
            'isEditable' => false
        )
    );

    if ($areCommentsEnabled === null) {
        $areCommentsEnabled = upstreamAreCommentsEnabledOnTasks();
    }

    if ($areMilestonesEnabled === false) {
        unset($schema['milestone']);
    }

    if (!$areCommentsEnabled) {
        unset($schema['comments']);
    }

    return apply_filters('upstream:project.tasks.fields', $schema);
}

function getBugsFields($severities = array(), $statuses = array(), $areCommentsEnabled = null)
{
    if (empty($severities)) {
        $severities = getBugsSeverities();
    }

    if (empty($statuses)) {
        $statuses = getBugsStatuses();
    }

    $options = null;

    $schema = array(
        'title' => array(
            'type'        => 'raw',
            'isOrderable' => true,
            'label'       => __('Title', 'upstream')
        ),
        'assigned_to' => array(
            'type'        => 'user',
            'isOrderable' => true,
            'label'       => __('Assigned To', 'upstream')
        ),
        'severity'       => array(
            'type'  => 'custom',
            'label' => __('Severity', 'upstream'),
            'isOrderable' => true,
            'renderCallback' => function($columnName, $columnValue, $column, $row, $rowType, $projectId) use (&$severities, &$options) {
                if (strlen($columnValue) > 0) {
                    if (isset($severities[$columnValue])) {
                        $columnValue = sprintf('<span class="label up-o-label" style="background-color: %s;">%s</span>', $severities[$columnValue]['color'], $severities[$columnValue]['name']);
                    } else {
                        $columnValue = sprintf(
                            '<span class="label up-o-label" title="%s" style="background-color: %s;">%s <i class="fa fa-ban"></i></span>',
                            __("This Severity doesn't exist anymore.", 'upstream'),
                            '#bdc3c7',
                            $columnValue
                        );
                    }
                } else {
                    $columnValue = sprintf('<i class="s-text-color-gray">%s</i>', __('none', 'upstream'));
                }

                return $columnValue;
            }
        ),
        'status'       => array(
            'type'  => 'custom',
            'label' => __('Status', 'upstream'),
            'isOrderable' => true,
            'renderCallback' => function($columnName, $columnValue, $column, $row, $rowType, $projectId) use (&$statuses, &$options) {
                if (strlen($columnValue) > 0) {
                    if (isset($statuses[$columnValue])) {
                        $columnValue = sprintf('<span class="label up-o-label" style="background-color: %s;">%s</span>', $statuses[$columnValue]['color'], $statuses[$columnValue]['name']);
                    } else {
                        $columnValue = sprintf(
                            '<span class="label up-o-label" title="%s" style="background-color: %s;">%s <i class="fa fa-ban"></i></span>',
                            __("This Status doesn't exist anymore.", 'upstream'),
                            '#bdc3c7',
                            $columnValue
                        );
                    }
                } else {
                    $columnValue = sprintf('<i class="s-text-color-gray">%s</i>', __('none', 'upstream'));
                }

                return $columnValue;
            }
        ),
        'due_date'  => array(
            'type'        => 'date',
            'isOrderable' => true,
            'label'       => __('Due Date', 'upstream')
        ),
        'file'    => array(
            'type'        => 'file',
            'isOrderable' => false,
            'label'       => __('File', 'upstream')
        ),
        'description' => array(
            'type'     => 'wysiwyg',
            'label'    => __('Description', 'upstream'),
            'isHidden' => true
        ),
        'comments'    => array(
            'type'     => 'comments',
            'label'    => __('Comments'),
            'isHidden' => true,
            'isEditable' => false
        )
    );

    if ($areCommentsEnabled === null) {
        $areCommentsEnabled = upstreamAreCommentsEnabledOnBugs();
    }

    if (!$areCommentsEnabled) {
        unset($schema['comments']);
    }

    return apply_filters('upstream:project.bugs.fields', $schema);
}

function getFilesFields($areCommentsEnabled = null)
{
    $schema = array(
        'title' => array(
            'type'        => 'raw',
            'isOrderable' => true,
            'label'       => __('Title', 'upstream')
        ),
        'created_by' => array(
            'type'        => 'user',
            'isOrderable' => true,
            'label'       => __('Uploaded by', 'upstream'),
            'isEditable'  => false
        ),
        'created_at'  => array(
            'type'        => 'date',
            'isOrderable' => true,
            'label'       => __('Upload Date', 'upstream'),
            'isEditable'  => false
        ),
        'assigned_to' => array(
            'type'        => 'user',
            'isOrderable' => false,
            'label'       => __('Assigned To', 'upstream')
        ),
        'file'    => array(
            'type'        => 'file',
            'isOrderable' => false,
            'label'       => __('File', 'upstream')
        ),
        'description' => array(
            'type'     => 'wysiwyg',
            'label'    => __('Description', 'upstream'),
            'isHidden' => true
        ),
        'comments'    => array(
            'type'     => 'comments',
            'label'    => __('Comments'),
            'isHidden' => true,
            'isEditable' => false
        )
    );

    if ($areCommentsEnabled === null) {
        $areCommentsEnabled = upstreamAreCommentsEnabledOnFiles();
    }

    if (!$areCommentsEnabled) {
        unset($schema['comments']);
    }

    return apply_filters('upstream:project.files.fields', $schema);
}

function renderTableHeaderColumn($identifier, $data)
{
    $attrs = array(
        'data-column' => $identifier,
        'class'       => isset($data['class']) ? (is_array($data['class']) ? implode(' ', $data['class']) : $data['class']) : '',
    );

    $isHidden = isset($data['isHidden']) && (bool)$data['isHidden'];
    if ($isHidden) return;

    $isOrderable = isset($data['isOrderable']) && (bool)$data['isOrderable'];
    if ($isOrderable) {
        $attrs['class'] .= ' is-clickable is-orderable';
        $attrs['role'] = 'button';
        $attrs['scope'] = 'col';
    }
    ?>
    <th <?php echo arrayToAttrs($attrs); ?>>
      <?php echo isset($data['label']) ? $data['label'] : ''; ?>
      <?php if ($isOrderable): ?>
        <span class="pull-right o-order-direction">
          <i class="fa fa-sort"></i>
        </span>
      <?php endif; ?>
    </th>
    <?php
}

function renderTableHeader($columns = array())
{
    ob_start(); ?>
    <thead>
      <?php if (!empty($columns)): ?>
      <tr scope="row">
        <?php
        foreach ($columns as $columnIdentifier => $column) {
            echo renderTableHeaderColumn($columnIdentifier, $column);
        }
        ?>
      </tr>
      <?php endif; ?>
    </thead>
    <?php
    $html = ob_get_contents();
    ob_end_clean();

    echo $html;
}

function renderTableColumnValue($columnName, $columnValue, $column, $row, $rowType, $projectId)
{
    $isHidden = isset($column['isHidden']) && (bool)$column['isHidden'] === true;

    $html = sprintf('<i class="s-text-color-gray">%s</i>', __('none', 'upstream'));
    $columnType = isset($column['type']) ? $column['type'] : 'raw';
    if ($columnType === 'user') {
        if (!is_array($columnValue)) {
            $columnValue = (array)$columnValue;
        }

        $usersIds = array_filter(array_unique($columnValue));
        $usersCount = count($usersIds);

        if ($usersCount > 1) {
            $users = get_users(array(
                'include' => $usersIds
            ));

            $columnValue = array();
            foreach ($users as $user) {
                $columnValue[] = $user->display_name;
            }
            unset($user, $users);

            $html = implode(',<br>', $columnValue);
        } else if ($usersCount === 1) {
            $user = get_user_by('id', $usersIds[0]);

            $html = $user->display_name;

            unset($user);
        }

        unset($usersCount, $usersIds);
    } else if ($columnType === 'percentage') {
        $html = sprintf('%d%%', (int)$columnValue);
    } else if ($columnType === 'date') {
        $columnValue = (int)$columnValue;
        if ($columnValue > 0) {
            $html = upstream_convert_UTC_date_to_timezone($columnValue, false);
        }
    } else if ($columnType === 'wysiwyg') {
        $columnValue = preg_replace('/(?!>[\s]*).\r?\n(?![\s]*<)/', '$0<br />', trim((string)$columnValue));
        if (strlen($columnValue) > 0) {
            $html = sprintf('<blockquote>%s</blockquote>', html_entity_decode($columnValue));
        } else {
            $html = '<br>' . $html;
        }
    } else if ($columnType === 'comments') {
        $html = upstreamRenderCommentsBox($row['id'], $rowType, $projectId, false, true);
    } else if ($columnType === 'custom') {
        if (isset($column['renderCallback']) && is_callable($column['renderCallback'])) {
            $html = call_user_func($column['renderCallback'], $columnName, $columnValue, $column, $row, $rowType, $projectId);
        }
    } else if ($columnType === 'file') {
        if (strlen($columnValue) > 0) {
          if (@is_array(getimagesize($columnValue))) {
            $html = sprintf(
              '<a href="%s" target="_blank">
                <img class="avatar itemfile" width="32" height="32" src="%1$s">
              </a>',
              $columnValue
            );
          } else {
            $html = sprintf(
              '<a href="%s" target="_blank">%s</a>',
              $columnValue,
              basename($columnValue)
            );
          }
        } else if ($isHidden) {
            $html = '<br>' . $html;
        }
    } else if ($columnType === 'array') {
        $columnValue = array_filter((array)$columnValue);

        if (isset($column['options'])) {
            $values = array();

            if (is_array($column['options'])) {
                foreach ($columnValue as $value) {
                    if (isset($column['options'][$value])) {
                        $values[] = $column['options'][$value];
                    }
                }
            }

            $values = implode(', ', $values);
        } else if (!empty($columnValue)) {
            $values = implode(', ', $columnValue);
        }

        if (!empty($values)) {
            if ($isHidden) {
                $html = '<br><span data-value="' . implode(',', $columnValue) . '">' . $values . '</span>';
            } else {
                $html = '<br><span>' . implode(',', $columnValue) . '</span>';
            }
        } else {
            $html = '<br>' . $html;
        }
    } else {
        $columnValue = trim((string)$columnValue);
        if (strlen($columnValue) > 0) {
            $html = esc_html($columnValue);
        }

        if ($isHidden) {
            $html = '<span data-value="'. esc_attr($columnValue) .'">' . $html . '</span>';
        }
    }

    $html = apply_filters('upstream:frontend:project.table.body.td_value', $html, $columnName, $columnValue, $column, $row, $rowType, $projectId);

    echo $html;
}

function renderTableBody($data, $visibleColumnsSchema, $hiddenColumnsSchema, $rowType, $projectId)
{
    $visibleColumnsSchemaCount = count($visibleColumnsSchema);
    ob_start(); ?>
    <tbody>
      <?php if (count($data) > 0):
        $isRowIndexOdd = true; ?>
        <?php foreach ($data as $id => $row):
        $rowAttrs = array(
            'class'   => 'is-filtered t-row-' . ($isRowIndexOdd ? 'odd' : 'even'),
            'data-id' => $id
        );

        if (!empty($hiddenColumnsSchema)) {
            $rowAttrs['class'] .= ' is-expandable';
            $rowAttrs['aria-expanded'] = 'false';
        }

        $isFirst = true;
        ?>
        <tr <?php echo arrayToAttrs($rowAttrs); ?>>
          <?php foreach ($visibleColumnsSchema as $columnName => $column):
          $columnValue = isset($row[$columnName]) ? $row[$columnName] : null;

            if ($column['type'] === 'user') {
                if (!is_array($columnValue)) {
                    $columnValue = array((int)$columnValue);
                }
            }

          $columnAttrs = array(
              'data-column' => $columnName,
              'data-value'  => $column['type'] === 'user' ? implode(',', $columnValue) : $columnValue,
              'data-type'   => $column['type']
          );

          if ($isFirst) {
              $columnAttrs['class'] = 'is-clickable';
              $columnAttrs['role'] = 'button';
          }
          ?>
          <td <?php echo arrayToAttrs($columnAttrs); ?>>
            <?php if ($isFirst): ?>
            <i class="fa fa-angle-right"></i>&nbsp;
            <?php endif; ?>

            <?php renderTableColumnValue($columnName, $columnValue, $column, $row, $rowType, $projectId); ?>
          </td>
          <?php $isFirst = false; ?>
          <?php endforeach; ?>
        </tr>

        <?php if (!empty($hiddenColumnsSchema)): ?>
        <tr data-parent="<?php echo $id; ?>" aria-expanded="false" style="display: none;">
          <td colspan="<?php echo $visibleColumnsSchemaCount; ?>">
            <div>
              <?php foreach ($hiddenColumnsSchema as $columnName => $column):
              $columnValue = isset($row[$columnName]) ? $row[$columnName] : null;
              ?>
              <div class="form-group" data-column="<?php echo $columnName; ?>">
                <label><?php echo isset($column['label']) ? $column['label'] : ''; ?></label>
                <?php renderTableColumnValue($columnName, $columnValue, $column, $row, $rowType, $projectId); ?>
              </div>
              <?php endforeach; ?>
            </div>
          </td>
        </tr>
        <?php endif;
        $isRowIndexOdd = !$isRowIndexOdd; ?>
        <?php endforeach; ?>
      <?php else: ?>
      <tr data-empty>
        <td colspan="<?php echo $visibleColumnsSchemaCount; ?>">
          <?php _e('No results found.', 'upstream'); ?>
        </td>
      </tr>
      <?php endif; ?>
    </tbody>
    <?php
    $html = ob_get_contents();
    ob_end_clean();

    echo $html;
}

function renderTable($tableAttrs = array(), $columnsSchema = array(), $data = array(), $itemType = '', $projectId = 0)
{
    $tableAttrs['class'] = array_filter(isset($tableAttrs['class']) ? (!is_array($tableAttrs['class']) ? explode(' ', $tableAttrs['class']) : (array)$tableAttrs['class']) : array());
    $tableAttrs['class'] = array_unique(array_merge($tableAttrs['class'], array(
        'o-data-table', 'table', 'table-bordered', 'table-responsive', 'table-hover', 'is-orderable'
    )));

    $tableAttrs['cellspacing'] = 0;
    $tableAttrs['width'] = '100%';

    $visibleColumnsSchema = array();
    $hiddenColumnsSchema = array();

    foreach ($columnsSchema as $columnName => $columnArgs) {
        if (isset($columnArgs['isHidden']) && (bool)$columnArgs['isHidden'] === true) {
            $hiddenColumnsSchema[$columnName] = $columnArgs;
        } else {
            $visibleColumnsSchema[$columnName] = $columnArgs;
        }
    }

    $tableAttrs['class'] = implode(' ', $tableAttrs['class']);
    ?>
    <table <?php echo arrayToAttrs($tableAttrs); ?>>
      <?php renderTableHeader($visibleColumnsSchema); ?>
      <?php renderTableBody($data, $visibleColumnsSchema, $hiddenColumnsSchema, $itemType, $projectId); ?>
    </table>
    <?php
}

function renderTableFilter($filterType, $columnName, $args = array(), $renderFormGroup = true)
{
    if (!in_array($filterType, array('search', 'select'))
        || empty($columnName)
    ) {
        return false;
    }

    $renderFormGroup = (bool)$renderFormGroup;

    $isHidden = !isset($args['hidden']) || (isset($args['hidden']) && (bool)$args['hidden'] === true);

    ob_start();

    if ($renderFormGroup) {
        echo '<div class="form-group">';
    }

    if ($filterType === 'search') {
        $inputAttrs = array(
            'type'                  => 'search',
            'class'                 => 'form-control',
            'data-column'           => $columnName,
            'data-compare-operator' => isset($args['operator']) ? $args['operator'] : 'contains'
        );

        if (isset($args['attrs']) && !empty($args['attrs'])) {
            $inputAttrs = array_merge($args['attrs'], $inputAttrs);
        }
        ?>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-search"></i>
          </div>
          <input <?php echo arrayToAttrs($inputAttrs); ?>>
        </div>
        <?php
    } else if ($filterType === 'select') {
        $inputAttrs = array(
            'class'       => 'form-control o-select2',
            'data-column' => $columnName,
            'multiple'    => 'multiple',
            'data-compare-operator' => isset($args['operator']) ? $args['operator'] : 'contains'
        );

        if (isset($args['attrs']) && !empty($args['attrs'])) {
            $inputAttrs = array_merge($args['attrs'], $inputAttrs);
        }

        $hasIcon = isset($args['icon']) && !empty($args['icon']);
        if ($hasIcon): ?>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-user"></i>
          </div>
        <?php endif; ?>

        <select <?php echo arrayToAttrs($inputAttrs); ?>>
          <option value></option>
          <option value="__none__"><?php _e('None', 'upstream'); ?></option>
          <?php
          if (isset($args['options']) && is_array($args['options']) && count($args['options'])): ?>
            <?php foreach ($args['options'] as $optionValue => $optionLabel): ?>
            <option value="<?php echo (string)$optionValue; ?>"><?php echo $optionLabel; ?></option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>

        <?php if ($hasIcon): ?>
        </div>
        <?php endif;
    }

    if ($renderFormGroup) {
        echo '</div>';
    }

    $filterHtml = ob_get_contents();
    ob_end_clean();

    echo $filterHtml;
}
