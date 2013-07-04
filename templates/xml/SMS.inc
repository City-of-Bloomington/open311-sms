<?php
	header("content-type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<Response>
<Sms><![CDATA[<?php echo ($this->includeSMSBlocks()) ?>]]>
</Sms>
</Response>
