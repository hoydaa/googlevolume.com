<?php use_helper('HoydaaJavascript') ?>

<table width="100%">
    <?php for($i = 0; $i < sizeof($reports) / 2; $i++): ?>
        <tr>
            <td valign="top">
                <?php include_component('report', 'miniChart', array('report' => $reports[$i * 2], 'sf_cache_key' => $reports[$i * 2]->getId())); ?>
            </td>
            <td valign="top">
                <?php 
                    if($i * 2 + 2 <= sizeof($reports))
                    {
                        echo include_component('report', 'miniChart', array('report' => $reports[$i * 2 + 1], 'sf_cache_key' => $reports[$i * 2 + 1]->getId()));
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
  function get_serie_label_content($chart)
  {
    $rtn = "";
    foreach($chart->getSeries()->getSeries() as $serie)
    {
      $rtn .= '<span style="background-color: #'. $serie->getColor() .'">'.$serie->getLabel().'</span><br/>';
    }
    return $rtn;
  }
?>
