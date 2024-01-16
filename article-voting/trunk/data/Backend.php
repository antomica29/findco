<?php

namespace ArticleVoting;

class Backend extends ArticleVoting
{
    /**
     * Backend constructor.
     */
    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'addArticleVoteMetaBox'));
    }

    /**
     * Add a custom meta box to the post editor screen
     */
    public function addArticleVoteMetaBox()
    {
        add_meta_box(
            'artice_votes',
            'Article Votes',
            [$this, 'displayArticleVoteMetaBox'],
            'post',
            'side',
            'low'
        );
    }

    /**
     * Callback function to display the content of the custom meta box
     *
     * @param WP_Post $post The current post object.
     */
    public function displayArticleVoteMetaBox($post)
    {
        //get voting counts
        $counts = $this->getVotingCounts(get_post_meta($post->ID, 'votes', true));

        //showing data in the meta box
        include plugin_dir_path(__DIR__) . 'views/widget.php';
    }
}