<?php use_helper('I18N', 'Validation', 'Form', 'Javascript') ?>

<h1><?php echo __('Create/Edit Report') ?></h1>

<?php 
	$element = "<div class=\"row\"><input type=\"text\" name=\"query_text\"><input type=\"text\" name=\"query_title\">" . link_to_function(__('Remove'), 'this.up().remove()') . "</div>";
	
	echo javascript_tag("
		function addQuery() {
			$(\"query-container\").insert('$element', $(\"row\"));
		}
	");
?>

<?php echo form_tag('report/update', array('class' => 'form')) ?>
    <?php echo input_hidden_tag('id', $sf_params->get('id')) ?>
    <div class="row">
        <?php echo label_for('title', __('Title')) ?>
        <?php echo input_tag('title', $sf_params->get('title')) ?>
        <?php //echo form_error('title') ?>
    </div>
    <div id="query-container">
    	<div class="row">
 			<?php echo label_for('query_text', __('Query Text')) ?>
 			<?php echo label_for('query_text', __('Query Title')) ?>
    	</div>
	    <?php if($sf_params->get('query_text')) : ?>
	    	<?php foreach($sf_params->get('query_text') as $query) : ?>
	    		
	    	<?php endforeach; ?>
	    <?php else: ?>
		    <div class="row">
		        <?php echo input_tag('query_text') ?>
		        <?php //echo form_error('query_text') ?>
		        <?php echo input_tag('query_title') ?>
		        <?php //echo form_error('query_title') ?>
		    </div>
	    <?php endif; ?>
    </div>
    <?php echo link_to_function(__('Add'), 'addQuery();') ?>
    <div class="row right_col">
        <?php echo submit_tag(__('Save')) ?>
    </div>
</form>