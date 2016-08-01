<?php

function medma_clone_factory($templateSiteId, $newSiteId, $config) {
    global $wpdb;
    $status = false;
    // init
    $config['template_site_id'] = $templateSiteId;
    $config['new_site_id'] = $newSiteId;
    $config['template_site_prefix'] = $wpdb->get_blog_prefix($templateSiteId);
    $config['new_site_prefix'] = $wpdb->get_blog_prefix($newSiteId);

    $beforeHandlerStatus = true;

    if (isset($config['before']) && is_callable($config['before'])) {
        $beforeHandlerStatus = call_user_func($config['before'], $config);
    }

    if ($beforeHandlerStatus) {
        if (isset($config['db'])) {
            if (isset($config['db']['tables'])) {
                foreach ($config['db']['tables'] as $key => $item) {
                    $table = is_int($key) ? $item : $key;
                    $tableConfig = is_int($key) ? array() : $item;

                    if (isset($tableConfig['row_filter'])) {
                        medma_clone_table_filter(
                            $config['template_site_prefix'] . $table,
                            $config['new_site_prefix'] . $table,
                            $tableConfig['row_filter'],
                            $table,
                            $config
                        );
                    } else {
                        medma_clone_table(
                            $config['template_site_prefix'] . $table,
                            $config['new_site_prefix'] . $table
                        );
                    }
                    //todo
                }
            }
        }

    }

    return $status;
}

function medma_clone_table($old_table, $new_table)
{
    /** @var wpdb */
    global $wpdb;

    $create_sql = $wpdb->get_var('SHOW CREATE TABLE `' . $old_table . '`', 1);
    if (!is_null($create_sql) && false !== $wpdb->query('DROP TABLE IF EXISTS `' . $new_table . '`')) {
        $create_sql = str_replace($old_table, $new_table, $create_sql);
        if (false !== $wpdb->query($create_sql)) {
            if (false === $wpdb->query('INSERT INTO `' . $new_table . '` SELECT * FROM `' . $old_table . '`')) {
                throw new Exception('Can\'t cope rows from ' . $old_table . ' to ' . $new_table);
            }
        } else {
            throw new Exception('Can\'t create table ' . $new_table . '<br/><br/>' . $create_sql);
        }
    } else {
        throw new Exception('Can\'t load table metadata ' . $old_table);
    }
}


function medma_clone_table_filter($old_table, $new_table, $filter, $table, $config)
{
    /** @var wpdb */
    global $wpdb;

    $create_sql = $wpdb->get_var('SHOW CREATE TABLE `' . $old_table . '`', 1);
    if (!is_null($create_sql) && false !== $wpdb->query('DROP TABLE IF EXISTS `' . $new_table . '`')) {
        $create_sql = str_replace($old_table, $new_table, $create_sql);
        if (false !== $wpdb->query($create_sql)) {
            $rows = $wpdb->get_results('SELECT * FROM `' . $old_table . '`', ARRAY_A);
            if (false !== $rows) foreach($rows as $row) {
                $insertData = call_user_func($filter, $row, $table, $config);
                $wpdb->insert($new_table, $insertData);
            }
        } else {
            throw new Exception('Can\'t create table ' . $new_table . '<br/><br/>' . $create_sql);
        }
    } else {
        throw new Exception('Can\'t load table metadata ' . $old_table);
    }
}

function mcf_replaceFilename($row, $table, $config) {
    $columns = $config['db']['tables'][$table]['columns'];
    foreach($columns as $columnName) {
        foreach ($config['db']['params']['replace'] as $key => $param) {
            $row[$columnName] = str_replace($param['search'], $param['replace'], $row[$columnName]);
        }
    }
    return $row;
}
