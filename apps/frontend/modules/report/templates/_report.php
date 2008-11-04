<?php use_helper('Javascript') ?>

<h2><?php echo $report->getTitle() ?></h2>

<div id="report-container">
	<?php include_component('report', 'chart', array('report' => $report)) ?>
	<div id="date-container">
		<?php echo link_to_remote('daily', array('update' => 'report-container', 'url' => 'hede/hede')) ?> 
		<?php echo link_to_remote('weekly', array('update' => 'report-container', 'url' => 'hede/hede')) ?> 
		<?php echo link_to_remote('monthly', array('update' => 'report-container', 'url' => 'hede/hede')) ?>
		<form action="<?php echo url_for('report/update') ?>" method="POST">
  			<table>
    			<?php echo $form ?>
    			<tr>
      				<td colspan="2">
        				<input type="submit" value="Save" />
      				</td>
    			</tr>
  			</table>
		</form>
	</div>
</div>