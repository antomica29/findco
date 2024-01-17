<div style='position: relative'>
    <div style="background: #eeeeee">
        <div style='position: absolute; height: 100%; width: <?= $counts['yes'] ?>%; background: #77d177'>
        </div>
        <div style='position: relative; z-index: 5; padding-left: 4px'><b>Yes Votes: </b><?= $counts['yes'] ?>%</div>
    </div>
</div><br>
<div style='position: relative'>
    <div style="background: #eeeeee">
        <div style='position: absolute; height: 100%; width: <?= $counts['no'] ?>%; background: #e77171'>
        </div>
        <div style='position: relative; z-index: 5; padding-left: 4px'><b>No Votes: </b><?= $counts['no'] ?>%</div>
    </div>
</div>