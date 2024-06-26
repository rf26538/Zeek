<?php

// Initialize the filter globals.
require dirname(__FILE__).'/TeachifyHook.php';

/** @var TeachifyHook[] $teachify_filter */
global $teachify_filter, $teachify_actions, $teachify_current_filter;

if ($teachify_filter) {
    $teachify_filter = TeachifyHook::build_preinitialized_hooks($teachify_filter);
} else {
    $teachify_filter = [];
}

if (! isset($teachify_actions)) {
    $teachify_actions = [];
}

if (! isset($teachify_current_filter)) {
    $teachify_current_filter = [];
}

/**
 * @param  int  $priority
 * @param  int  $accepted_args
 * @return bool
 */
function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1)
{
    global $teachify_filter;
    if (! isset($teachify_filter[$tag])) {
        $teachify_filter[$tag] = new TeachifyHook();
    }
    $teachify_filter[$tag]->add_filter($tag, $function_to_add, $priority, $accepted_args);

    return true;
}

/**
 * @param  bool  $function_to_check
 * @return bool|int
 */
function has_filter($tag, $function_to_check = false)
{
    global $teachify_filter;

    if (! isset($teachify_filter[$tag])) {
        return false;
    }

    return $teachify_filter[$tag]->has_filter($tag, $function_to_check);
}

/**
 * @return mixed
 */
function apply_filters($tag, $value)
{
    global $teachify_filter, $teachify_current_filter;

    $args = func_get_args();

    // Do 'all' actions first.
    if (isset($teachify_filter['all'])) {
        $teachify_current_filter[] = $tag;
        _teachify_call_all_hook($args);
    }

    if (! isset($teachify_filter[$tag])) {
        if (isset($teachify_filter['all'])) {
            array_pop($teachify_current_filter);
        }

        return $value;
    }

    if (! isset($teachify_filter['all'])) {
        $teachify_current_filter[] = $tag;
    }

    // Don't pass the tag name to TeachifyHook.
    array_shift($args);

    $filtered = $teachify_filter[$tag]->apply_filters($value, $args);

    array_pop($teachify_current_filter);

    return $filtered;
}

/**
 * @return mixed
 */
function apply_filters_ref_array($tag, $args)
{
    global $teachify_filter, $teachify_current_filter;

    // Do 'all' actions first
    if (isset($teachify_filter['all'])) {
        $teachify_current_filter[] = $tag;
        $all_args = func_get_args();
        _teachify_call_all_hook($all_args);
    }

    if (! isset($teachify_filter[$tag])) {
        if (isset($teachify_filter['all'])) {
            array_pop($teachify_current_filter);
        }

        return $args[0];
    }

    if (! isset($teachify_filter['all'])) {
        $teachify_current_filter[] = $tag;
    }

    $filtered = $teachify_filter[$tag]->apply_filters($args[0], $args);

    array_pop($teachify_current_filter);

    return $filtered;
}

/**
 * @param  int  $priority
 * @return bool
 */
function remove_filter($tag, $function_to_remove, $priority = 10)
{
    global $teachify_filter;

    $r = false;
    if (isset($teachify_filter[$tag])) {
        $r = $teachify_filter[$tag]->remove_filter($tag, $function_to_remove, $priority);
        if (! $teachify_filter[$tag]->callbacks) {
            unset($teachify_filter[$tag]);
        }
    }

    return $r;
}

/**
 * @param  bool  $priority
 * @return bool
 */
function remove_all_filters($tag, $priority = false)
{
    global $teachify_filter;

    if (isset($teachify_filter[$tag])) {
        $teachify_filter[$tag]->remove_all_filters($priority);
        if (! $teachify_filter[$tag]->has_filters()) {
            unset($teachify_filter[$tag]);
        }
    }

    return true;
}

/**
 * @return mixed
 */
function current_filter()
{
    global $teachify_current_filter;

    return end($teachify_current_filter);
}

/**
 * @return string
 */
function current_action()
{
    return current_filter();
}

/**
 * @param  null  $filter
 * @return bool
 */
function doing_filter($filter = null)
{
    global $teachify_current_filter;

    if (null === $filter) {
        return ! empty($teachify_current_filter);
    }

    return in_array($filter, $teachify_current_filter);
}

/**
 * @param  null  $action
 * @return bool
 */
function doing_action($action = null)
{
    return doing_filter($action);
}

/**
 * @param  int  $priority
 * @param  int  $accepted_args
 * @return true
 */
function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1)
{
    return add_filter($tag, $function_to_add, $priority, $accepted_args);
}

/**
 * @param  mixed  ...$arg
 */
function do_action($tag, ...$arg)
{
    global $teachify_filter, $teachify_actions, $teachify_current_filter;

    if (! isset($teachify_actions[$tag])) {
        $teachify_actions[$tag] = 1;
    } else {
        $teachify_actions[$tag]++;
    }

    // Do 'all' actions first
    if (isset($teachify_filter['all'])) {
        $teachify_current_filter[] = $tag;
        $all_args = func_get_args();
        _teachify_call_all_hook($all_args);
    }

    if (! isset($teachify_filter[$tag])) {
        if (isset($teachify_filter['all'])) {
            array_pop($teachify_current_filter);
        }

        return;
    }

    if (! isset($teachify_filter['all'])) {
        $teachify_current_filter[] = $tag;
    }

    if (empty($arg)) {
        $arg[] = '';
    } elseif (is_array($arg[0]) && 1 === count($arg[0]) && isset($arg[0][0]) && is_object($arg[0][0])) {
        // Backward compatibility for PHP4-style passing of `array( &$this )` as action `$arg`.
        $arg[0] = $arg[0][0];
    }

    $teachify_filter[$tag]->do_action($arg);

    array_pop($teachify_current_filter);
}

/**
 * @return int
 */
function did_action($tag)
{
    global $teachify_actions;

    if (! isset($teachify_actions[$tag])) {
        return 0;
    }

    return $teachify_actions[$tag];
}

function do_action_ref_array($tag, $args)
{
    global $teachify_filter, $teachify_actions, $teachify_current_filter;

    if (! isset($teachify_actions[$tag])) {
        $teachify_actions[$tag] = 1;
    } else {
        $teachify_actions[$tag]++;
    }

    // Do 'all' actions first
    if (isset($teachify_filter['all'])) {
        $teachify_current_filter[] = $tag;
        $all_args = func_get_args();
        _teachify_call_all_hook($all_args);
    }

    if (! isset($teachify_filter[$tag])) {
        if (isset($teachify_filter['all'])) {
            array_pop($teachify_current_filter);
        }

        return;
    }

    if (! isset($teachify_filter['all'])) {
        $teachify_current_filter[] = $tag;
    }

    $teachify_filter[$tag]->do_action($args);

    array_pop($teachify_current_filter);
}

/**
 * @param  bool  $function_to_check
 * @return false|int
 */
function has_action($tag, $function_to_check = false)
{
    return has_filter($tag, $function_to_check);
}

/**
 * @param  int  $priority
 * @return bool
 */
function remove_action($tag, $function_to_remove, $priority = 10)
{
    return remove_filter($tag, $function_to_remove, $priority);
}

/**
 * @param  bool  $priority
 * @return true
 */
function remove_all_actions($tag, $priority = false)
{
    return remove_all_filters($tag, $priority);
}

function _teachify_call_all_hook($args)
{
    global $teachify_filter;

    $teachify_filter['all']->do_all_hook($args);
}

function _teachify_filter_build_unique_id($tag, $function, $priority)
{
    global $teachify_filter;
    static $filter_id_count = 0;

    if (is_string($function)) {
        return $function;
    }

    if (is_object($function)) {
        // Closures are currently implemented as objects
        $function = [$function, ''];
    } else {
        $function = (array) $function;
    }

    if (is_object($function[0])) {
        // Object Class Calling
        return spl_object_hash($function[0]).$function[1];
    } elseif (is_string($function[0])) {
        // Static Calling
        return $function[0].'::'.$function[1];
    }
}
