<?php

$url = url_for('@chart_image?id=' . $report->getId(), true);

$embed = '
<a href="' . url_for('report/show?id=' . $report->getId(), true) . '" title="Google Volume">
    <img src="' . $url . '" alt="' . $report->getTitle() . '" />
</a>';

?>

<h2>Share</h2>

<p>To share the chart, copy the URL and send it to whomever you like. To embed
the chart, just copy the code from the "Embed" box. Once you've copied the code,
just paste it into your website or blog to embed it.</p>

<div class="panel">
    <div class="row">
        <label for="share_url">URL</label>
        <input id="share_url" type="text" value="<?php echo $url ?>" onclick="javascript:this.focus();this.select();" />
    </div>
    <div class="row">
        <label for="share_embed">Embed</label>
        <textarea id="share_embed" wrap="off" rows="3" cols="50" onclick="javascript:this.focus();this.select();"><?php echo htmlentities($embed) ?></textarea>
    </div>
</div>