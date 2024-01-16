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

        //some style
        $styleBG = 'position: absolute; height: 100%;';
        $styleDiv = 'position: relative; z-index: 5; padding-left: 4px';

        //showing data in the meta box
        echo "<div style='position: relative'><div style='" . $styleBG . "; width:" . $counts['yes'] . "%; background: #77d177'></div> <div style='" . $styleDiv . "'><b>Yes Votes: </b>" . $counts['yes'] . "% </div></div><br>
        <div style='position: relative'><div style='" . $styleBG . "; width:" . $counts['no'] . "%; background: #e77171'></div> <div style='" . $styleDiv . "'><b>No Votes: </b>" . $counts['no'] . "% </div></div>";
    }
}