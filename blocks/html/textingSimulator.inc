<?php
/**
 * @copyright 2007-2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 */
?>
<h2>SMS Simulator</h2>
<form class="form-horizontal">
	<div class='form-group'>
			<label for="SMSFrom" class="col-lg-2 control-label">From:</label>
			<div class='col-lg-10'>
			<input name="SMSFrom" class="form-control" id="SMSFrom"); ?>
			</div>
      	</div>
	<div class='form-group'>
			<label for="SMSText" class="col-lg-2 control-label">Text:</label>
			<div class='col-lg-10'>
			<input name="SMSText" class="form-control" id="SMSText"); ?>
			</div>
      	</div>

<button id="Submit" class="btn btn-primary">Submit</button>
</form>
<p></p>
<div class="panel" id="responsePanel">
	<div class="panel-heading">Response:</div>
	<div id="SMSResponse"></div>	
</div>
<p></p>
<div class="panel" id="countPanel">
	<div class="panel-heading" id="countHeading" >Character Count:</div>
	<div id="SMSResponseCount"></div>	
</div>



