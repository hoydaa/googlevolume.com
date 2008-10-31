<?php use_helper('I18N', 'HoydaaJavascript') ?>

<h1><?php echo __('Create/Edit Report') ?></h1>

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

<?php echo hoydaa_auto_complete('report_tags', 'tag/autocomplete', array('use_style' => 'true', 'tokens' => ',')) ?>