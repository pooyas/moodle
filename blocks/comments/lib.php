<?php

/**
 * The comments block helper functions and callbacks
 *
 * @package    block
 * @subpackage comments
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Validate comment parameter before perform other comments actions
 *
 * @param stdClass $comment_param {
 *              context  => context the context object
 *              courseid => int course id
 *              cm       => stdClass course module object
 *              commentarea => string comment area
 *              itemid      => int itemid
 * }
 * @return boolean
 */
function block_comments_comment_validate($comment_param) {
    if ($comment_param->commentarea != 'page_comments') {
        throw new comment_exception('invalidcommentarea');
    }
    if ($comment_param->itemid != 0) {
        throw new comment_exception('invalidcommentitemid');
    }
    return true;
}

/**
 * Running addtional permission check on plugins
 *
 * @param stdClass $args
 * @return array
 */
function block_comments_comment_permissions($args) {
    return array('post'=>true, 'view'=>true);
}

/**
 * Validate comment data before displaying comments
 *
 * @param stdClass $comment
 * @param stdClass $args
 * @return boolean
 */
function block_comments_comment_display($comments, $args) {
    if ($args->commentarea != 'page_comments') {
        throw new comment_exception('invalidcommentarea');
    }
    if ($args->itemid != 0) {
        throw new comment_exception('invalidcommentitemid');
    }
    return $comments;
}
