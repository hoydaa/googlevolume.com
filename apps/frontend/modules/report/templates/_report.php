<?php use_helper('Javascript', 'HoydaaJavascript') ?>

<h2><?php echo $report->getTitle() ?></h2>

<div id="report-container">
	<?php include_component('report', 'chart', array(
	  'report' => $report, 
	  'start_date' => $form->getValue('start_date'), 
	  'end_date' => $form->getValue('end_date'))) ?>
	<div id="date-container">
		<?php $frequency_arr = QueryResultPeer::$frequency_arr ?>
		<?php foreach($frequency_arr as $frequency): ?>
			<?php if($form->getValue('frequency') == $frequency): ?>
				<?php echo $frequency ?>&nbsp;
			<?php else: ?>
				<?php echo link_to($frequency, '#', array('onclick' => "$('date_selector_frequency').value='$frequency';$('date_selector_form').submit();")) ?>&nbsp;
			<?php endif; ?>
		<?php endforeach; ?>
		<!--<form action="<?php echo url_for('report/update') ?>" method="POST">-->
		<?php echo form_remote_tag(
			array('url' => 'report/chart?id=' . $report->getId(), 'update' => 'report-container'), 
			array('id' => 'date_selector_form')) ?>
  			<table>
    			<?php echo $form ?>
    			<tr>
      				<td colspan="2">
        				<input type="submit" value="Update" />
      				</td>
    			</tr>
  			</table>
		</form>
	</div>
</div>