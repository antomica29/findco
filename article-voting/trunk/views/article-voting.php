<div class="article-voting <?php if($voted){ echo "voted"; } ?>" data-post="<?= $postId ?>">
    <div class="question"><?= $text ?></div>
    <div class="vote_button yes <?php if ($voted && $votedYes) {
        echo "voted";
    } ?>">
        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 122.88 122.88"
             width="20" height="20">
            <path fill="#999999" class="circle"
                  d="M45.54,2.11A61.42,61.42,0,1,1,2.11,77.34,61.42,61.42,0,0,1,45.54,2.11Z"/>
            <path fill="#ffffff" class="cls-2"
                  d="M45.78,32.27c4.3,0,7.79,5,7.79,11.27s-3.49,11.27-7.79,11.27S38,49.77,38,43.54s3.48-11.27,7.78-11.27Z"/>
            <path fill="#ffffff" class="cls-2"
                  d="M77.1,32.27c4.3,0,7.78,5,7.78,11.27S81.4,54.81,77.1,54.81s-7.79-5-7.79-11.27S72.8,32.27,77.1,32.27Z"/>
            <path fill="#ffffff"
                  d="M28.8,70.82a39.65,39.65,0,0,0,8.83,8.41,42.72,42.72,0,0,0,25,7.53,40.44,40.44,0,0,0,24.12-8.12,35.75,35.75,0,0,0,7.49-7.87.22.22,0,0,1,.31,0L97,73.14a.21.21,0,0,1,0,.29A45.87,45.87,0,0,1,82.89,88.58,37.67,37.67,0,0,1,62.83,95a39,39,0,0,1-20.68-5.55A50.52,50.52,0,0,1,25.9,73.57a.23.23,0,0,1,0-.28l2.52-2.5a.22.22,0,0,1,.32,0l0,0Z"/>
        </svg>
        <span><?= $yesText ?></span>
    </div>
    <div class="vote_button no  <?php if ($voted && !$votedYes) {
        echo "voted";
    } ?>">
        <svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision"
             text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd"
             clip-rule="evenodd" viewBox="0 0 512 512.002" width="20" height="20">
            <circle fill="#999999" class="circle"
                    transform="matrix(2.6439 -.70843 .70843 2.64391 256 256.001)"
                    r="93.504"/>
            <path fill="#ffffff" fill-rule="nonzero"
                  d="M148.542 353.448c-11.076 0-20.055-8.979-20.055-20.054 0-11.076 8.979-20.055 20.055-20.055h214.917c11.075 0 20.054 8.979 20.054 20.055 0 11.075-8.979 20.054-20.054 20.054H148.542zm161.919-125.465c-11.076 0-20.055-8.979-20.055-20.055s8.979-20.055 20.055-20.055h65.814c11.075 0 20.054 8.979 20.054 20.055s-8.979 20.055-20.054 20.055h-65.814zm-174.735 0c-11.076 0-20.055-8.979-20.055-20.055s8.979-20.055 20.055-20.055h64.45c11.076 0 20.055 8.979 20.055 20.055s-8.979 20.055-20.055 20.055h-64.45z"/>
        </svg>
        <span><?= $noText ?></span>
    </div>
</div>