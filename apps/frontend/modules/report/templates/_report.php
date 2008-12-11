<?php use_helper('Javascript', 'HoydaaJavascript') ?>

<div id="report-container">
	<p><strong>Description: </strong><?php echo $report->getDescription() ?></p>
	<?php if($form->isValid()): ?>
	    <?php include_component('report', 'chart', array(
	  		'report'     => $report, 
	  		'start_date' => $form->getValue('start_date'), 
	  		'end_date'   => $form->getValue('end_date'),
	  		'frequency'  => $form->getValue('frequency'))) ?>
	<?php endif; ?>
	<div id="date-container">
		<?php echo form_remote_tag(
			array('url' => 'report/chart?id=' . $report->getId(), 'update' => 'report-container'), 
			array('id' => 'date_selector_form')) ?>
		<table>
			<tr>
				<td colspan="4" align="left">
					<?php echo $form['start_date']->renderError(); ?>
					<?php echo $form['end_date']->renderError(); ?>
					<?php echo $form['frequency']->renderError(); ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $form['start_date']->renderLabel(); ?></td>
				<td><?php echo $form['end_date']->renderLabel(); ?></td>
				<td><?php echo $form['frequency']->renderLabel(); ?></td>
				<td></td>
			</tr>
			<tr>
				<td><?php echo $form['start_date']; ?></td>
				<td><?php echo $form['end_date']; ?></td>
				<td><?php echo $form['frequency']; ?></td>
				<td><input type="submit" value="Update Chart" /></td>
			</tr>
		</table>
		</form>
	</div>
</div>