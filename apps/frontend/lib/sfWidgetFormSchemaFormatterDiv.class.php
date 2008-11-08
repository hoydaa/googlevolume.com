<?php

class sfWidgetFormSchemaFormatterDiv extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat       = '<div class="row">%error% %label% %field% %help% %hidden_fields%</div>',
    $errorRowFormat  = "%errors%",
    $helpFormat      = '<br />%help%',
    $decoratorFormat = "%content%";
}
