<?php use_helper('I18N') ?>

<h1><?php echo $report->getTitle() ?></h1>

<table>
	<tr>
		<th><?php echo __('Title') ?></th>
		<td><?php echo $report->getTitle() ?></td>
	</tr>
	<tr>
		<th><?php echo __('Description') ?></th>
		<td><?php echo $report->getDescription() ?></td>
	</tr>
	<?php $i = 1 ?>
	<?php foreach($report->getReportQuerys() as $report_query) : ?>
		<tr>
			<th><?php echo __('Query Text') . " $i" ?></th>
			<td><?php echo $report_query->getQuery()->getQuery() ?></td>
		</tr>
		<tr>
			<th><?php echo __('Query Title') . " $i" ?></th>
			<td><?php echo $report_query->getTitle() ?></td>
		</tr>
		<?php $i++ ?>
	<?php endforeach; ?>
	<tr>
		<th><?php echo __('Tags') ?></th>
		<td><?php echo $report->getTag() ?></td>
	</tr>
</table>

<?php include_partial('report/report', array('report' => $report)) ?>