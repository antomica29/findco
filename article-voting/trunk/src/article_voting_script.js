document.addEventListener('DOMContentLoaded', function () {
    //get dom elements
    const voteButtons = document.querySelectorAll('.vote_button');
    const articleVoting = document.querySelector('.article-voting');
    let voted = articleVoting.classList.contains('voted');

    //function to handle the Ajax response
    function handleAjaxResponse(response) {

        //change text from response text
        articleVoting.querySelector('.question').textContent = response.text;

        //change each buttons text with voting counts
        voteButtons.forEach((button) => {
            const span = button.querySelector('span');
            span.textContent = button.classList.contains('yes') ? response.yes_count : response.no_count;
        });

        //set voted true to block further voting
        voted = true;
    }

    //make the Ajax Call with vote choice and the post ID to update meta
    function makeAjaxRequest(voteChoice, postID) {
        //request settings, url + data including methods name with vote and post_id sent as POST
        const ajaxUrl = '/wp-admin/admin-ajax.php';
        const data = `action=article_voting_ajax_action&vote=${encodeURIComponent(voteChoice)}&post_id=${postID}`;

        //init the ajax request
        const ajax = new XMLHttpRequest();

        //after we get a response back we check for statuses
        ajax.onreadystatechange = function () {
            if (ajax.readyState === 4) {
                //if successful enter to parse data and handle response
                if (ajax.status === 200) {
                    const response = JSON.parse(ajax.responseText);
                    handleAjaxResponse(response);
                } else {
                    console.error('AJAX error:', ajax.statusText);
                }
            }
        };

        // Open and send the AJAX request
        ajax.open('POST', ajaxUrl, true);
        ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        ajax.send(data);
    }

    //function that takes care of the button click event
    function handleClickEvent(button) {
        //we chck that it is not voted, then get the vote data and post ID and make the Ajax request after
        if (!voted) {
            const voteChoice = button.classList.contains('yes') ? 'yes' : 'no';
            const postID = articleVoting.dataset.post;
            makeAjaxRequest(voteChoice, postID);

            //set article as voted, set button clicked as voted and highlight it
            articleVoting.classList.add('voted');
            button.classList.add('voted');
        }
    }

    //attach a click event listener to each 'vote_button' element
    voteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            handleClickEvent(button);
        });
    });
});
