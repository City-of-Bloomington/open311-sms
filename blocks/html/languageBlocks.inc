<?php
/**
 * @copyright 2007-2012 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Abhiroop Bhatnagar <bhatnagarabhiroop@gmail.com>
 * @param language $this->languageBlockList
 */
$blockTypeList=LanguageBlockList::getTypeList($this->languageBlockList);
?>


<div class="container">
	<h2>Language Editor</h2>
	<form method="post" action="<?php echo $_SERVER['REDIRECT_URL']; ?>" class='form-horizontal'>
		<fieldset>
		<?php
		$html = '<ul class="nav nav-tabs">';
		foreach ($blockTypeList as $type)
		{
			$html.='<li><a href="#'.$type.'" data-toggle="tab">'.$type.'</a></li>';
		}
		$html.= '</ul><p></p>';
		$html.= '<div class="tab-content">';
		$first=TRUE;
		foreach ($blockTypeList as $type)
		{	
			$status=$first?'active':NULL;
			$html.='<div class="tab-pane '.$status.'" id="'.$type.'">';
			$first=FALSE;
			foreach ($this->languageBlockList as $blockName=>$blockParam)
			{
				if($blockParam['blockType']==$type)
				{
					$html.='<div class="form-group">
					         <label for="'.$blockName.'" class="col-lg-4 control-label">'.$blockName.'</label>
					         <div class="col-lg-7">
					          <input name="'.$blockName.'" class="form-control" id="'.$blockName.'" value="'.View::escape($blockParam['blockValue']).'" />
					         </div>
		      		               </div>';
				}
			}
			$html.='</div>';
		}
		$html.='</div>';				
		echo $html;
		?>		

		<fieldset><legend>Submit</legend>
			<button type="submit" class="btn btn-primary">Submit</button>
			<?php
				if (isset($_REQUEST['return_url'])) {
					$return_url = urlencode($_REQUEST['return_url']);
				}
				
				else {
					$return_url = BASE_URI.'/language/update';
				}

				$onclick = isset($_REQUEST['callback'])	? 'onclick="self.close();"': '';
				echo "<a class=\"cancel\" href=\"$return_url\" $onclick>Cancel</a>";
			?>
		</fieldset>
	</form>
</div>
<p></p>
