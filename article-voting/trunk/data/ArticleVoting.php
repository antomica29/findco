<?php

namespace ArticleVoting;

require_once 'FingerprintChecks.php';

class ArticleVoting
{
    /**
     * @var int The post ID.
     */
    public $postId;

    /**
     * @var bool Indicates whether the user has voted.
     */
    public $voted = false;

    /**
     * @var bool Indicates whether the user voted 'Yes'.
     */
    public $votedYes = false;

    /**
     * @var string The text for 'Yes' option.
     */
    public $yesText = "Yes";

    /**
     * @var string The text for 'No' option.
     */
    public $noText = "No";

    /**
     * @var FingerprintChecks An instance of the FingerprintChecks class.
     */
    public $checks;

    /**
     * ArticleVoting constructor.
     *
     * @action wp_enqueue_scripts Enqueue scripts and styles.
     * @action the_content Render the voting interface in the content.
     * @action wp_ajax_article_voting_ajax_action Handle AJAX voting requests for logged-in users.
     * @action wp_ajax_nopriv_article_voting_ajax_action Handle AJAX voting requests for non-logged-in users.
     */
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'articleVotingEnqueueScript']);
        add_action('the_content', [$this, 'render']);
        add_action('wp_ajax_article_voting_ajax_action', [$this, 'votingAjaxFunction']);
        add_action('wp_ajax_nopriv_article_voting_ajax_action', [$this, 'votingAjaxFunction']);

        //init FingerprintChecks class
        $this->checks = new FingerprintChecks();
    }

    /**
     * Enqueue styles and scripts for the plugin.
     */
    public function articleVotingEnqueueScript()
    {
        wp_enqueue_style('article_voting_style', plugin_dir_url(__DIR__) . 'src/article_voting_style.css');
        wp_enqueue_script('article_voting_script', plugin_dir_url(__DIR__) . 'src/article_voting_script.js', array(), time());
    }

    /**
     * Render the voting interface on the front-end.
     *
     * @param string $content The post content.
     *
     * @return string The modified post content.
     */
    public function render($content)
    {
        if (get_post_type() == 'post') {
            $articleVotingFrontendPath = plugin_dir_path(__DIR__) . 'views/article-voting.php';

            //check if the path for the file exists and fingerprint checks pass
            if (file_exists($articleVotingFrontendPath) && $this->checks->checkFingerprintOK()) {

                //get the post id to check if the user voted
                $this->postId = $postId = get_the_ID();
                $this->checkIfVoted($this->postId);

                //set variable for front-end
                $voted = $this->voted;
                $votedYes = $this->votedYes;
                $text = $voted ? __("Thank you for your feedback.", "findco") : __("Was this article helpful?", "findco");
                $yesText = $this->yesText;
                $noText = $this->noText;

                //include the front-end file
                ob_start();
                include $articleVotingFrontendPath;
                $customContent = ob_get_clean();
            } else {
                $customContent = '<div>' . __("Disable Proxy To Vote and See Voting", "findco") . '</div>';
            }

            //append new content to the rest of the page content
            $content .= $customContent;
        }

        //return content so we do not get an empty page
        return $content;
    }

    /**
     * Check if the user has voted and update voting information.
     *
     * @param int $postId The post ID.
     */
    private function checkIfVoted($postId)
    {
        //IP of user and search for it in the post meta
        $ip = $_SERVER['REMOTE_ADDR'];
        $postMeta = get_post_meta($postId, 'votes', true);
        $search = $ip . ":";
        $position = strpos($postMeta, $search);

        //if the ID is found we set voted to true, and check if voted yes
        if ($position !== false) {
            $this->voted = true;
            $this->votedYes = substr($postMeta, $position + strlen($search), 3) == "yes";
        }

        //calling voting count function
        $counts = $this->getVotingCounts($postMeta);

        //check if counts yes and no are not 0, and it is also voted
        if ($counts['yes'] !== 0 && $counts['no'] !== 0 && $this->voted) {
            $this->yesText = $counts['yes'] . "%";
            $this->noText = $counts['no'] . "%";
        }
    }

    /**
     * Calculate voting counts in percentage.
     *
     * @param string $meta The post meta.
     *
     * @return array An associative array with 'yes' and 'no' percentages.
     */
    public function getVotingCounts($meta)
    {
        //get all instances of yes and no and count them together
        $yes = substr_count($meta, "yes");
        $no = substr_count($meta, "no");
        $total = $yes + $no;

        $yesCount = 0;
        $noCount = 0;

        //check total that is not 0, and yes the % of yes and no.
        if ($total !== 0) {
            $yesCount = round(($yes / $total) * 100, 0);
            $noCount = 100 - $yesCount;
        }

        return ["yes" => $yesCount, "no" => $noCount];
    }

    /**
     * Handle AJAX voting requests from the front-end.
     */
    public function votingAjaxFunction()
    {
        if (isset($_POST['vote'])) {
            $vote = sanitize_text_field($_POST['vote']);
            $postId = sanitize_text_field($_POST['post_id']);

            $this->voted = true;
            $this->votedYes = ($vote == 'yes') ? "yes" : "";

            //get postmeta, and append new vote to the old post meta
            $postMeta = get_post_meta($postId, 'votes', true);
            $updatedMeta = $postMeta . $_SERVER['REMOTE_ADDR'] . ":" . $vote . "|";
            update_post_meta($postId, 'votes', $updatedMeta);

            //get vote counts
            $counts = $this->getVotingCounts($updatedMeta);

            $response = [
                'text'      => __("Thank you for your feedback.", "findco"),
                'yes_count' => $counts['yes'] . "%",
                'no_count'  => $counts['no'] . "%",
            ];
        } else {
            $response = ['error' => 'Vote parameter not set.'];
        }

        wp_send_json($response);
    }
}
