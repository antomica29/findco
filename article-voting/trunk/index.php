<?php
/**
 * Plugin Name: Article Voting
 * Description: A plugin that shows a question and yes/no answer in the front end right below the content automatically for single pages. Also displays the result in the backend in the sidebar.
 * Version: 1.0
 * Author: anton
 **/

use ArticleVoting\ArticleVoting;
use ArticleVoting\Backend;

require_once plugin_dir_path(__FILE__) . 'data/ArticleVoting.php';

/**
 * @var ArticleVoting $article_voting_plugin An instance of the main ArticleVoting class.
 */
$article_voting_plugin = new ArticleVoting();

// Check if in the backend area and single page
if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . 'data/Backend.php';

    /**
     * @var Backend $backend An instance of the Backend class.
     */
    $backend = new Backend();
}