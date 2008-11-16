<?php use_helper('HoydaaJavascript') ?>

<table width="100%">
    <?php for($i = 0; $i < sizeof($charts) / 2; $i++): ?>
        <tr>
            <td>
                <?php include_partial('report/mini', array('report' => $reports[$i * 2], 'chart' => $charts[$i * 2], 'labels' => $serie_labels[$i * 2])); ?>
            </td>
            <td>
                <?php 
                    if($i * 2 + 2 <= sizeof($charts))
                    {
                        echo include_partial('report/mini', array('report' => $reports[$i * 2 + 1], 'chart' => $charts[$i * 2 + 1], 'labels' => $serie_labels[$i * 2 + 1]));
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
    <?php endfor; ?>
</table>

<?php
  function get_serie_label_content($array)
  {
    $rtn = "";
    foreach($array as $item)
    {
      $rtn .= '<span style="background-color: '. $item['color'] .'">'.$item['title'].'</span><br/>';
    }
    return $rtn;
  }
?>
