<?php
/*
 * @package component Insurance for Joomla! 3.x
 * @version $Id: com_Insurance 1.0.0 2017-10-10 23:26:33Z $
 * @author Kian William Nowrouzian
 * @copyright (C) 2016- Kian William Nowrouzian
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 
 This file is part of Insurance.
    Insurance is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    Insurance is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with Insurance.  If not, see <http://www.gnu.org/licenses/>.
 
*/
?>
<?php
defined('_JEXEC') or die('Restricted access');   
JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');
   jimport('joomla.html.pagination');
   jimport( 'joomla.html.html' );
   
jimport('joomla.filesystem.file');
      jimport('joomla.filesystem.folder');
	  
	  $jinput = JFactory::getApplication()->input;
	  $data = $jinput->post->getArray();
	  if(!empty($data['sclient']))	  
	  $searched = $data['sclient'];
	  if(!empty($data['issearched']))
	  $issearched = $data['issearched'];
	 
   
$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$canOrder = true; 
$saveOrder = $listOrder == 'a.ordering';
$input = JFactory::getApplication()->input;
$page  = $input->get('limitstart', 0); 
	if(!empty($input->get('recordslimit')))
       $limit = intval($input->get('recordslimit'));
   else
	   if(!empty($input->get('recslimit')))
		   $limit = $input->get('recslimit');
	   else
	       $limit = 5;

?>

<script type="text/javascript">
	
	
   Joomla.submitbutton = function(task)
    {
        if (task == 'insuranceclients.deleteGama')
        {
            if (confirm('Do you really want to delete these items?')) {
                Joomla.submitform(task);
            } else {
                return false;
            }
        }
		else
			Joomla.submitform(task);

    }

	

</script>

<form action="<?php JRoute::_('index.php?option=com_insurance&view=insuranceclients'); ?>" method="post" name="adminForm" id="adminForm">


	<div class="clr"> </div>
	<table class="adminlist">
		<thead>
		    <tr>
                <th width="1%" align="left">
                    <input type="checkbox" name="checkall-toggle" value="" onclick="Joomla.checkAll(this)" />
                </th>
                <th width="1%">
				<div style="color:#7ab7f5;padding:5px;border:3px solid darkgreen;border-radius:5%; text-align:justify;margin-bottom:5px;background-color:#000">
				Below are the data from clients which were input into the forms.
				Do not change key values in textarea or the client will not be able to complete the 
				half-filled forms.
				<span style="color:darkgreen">
				Also certain values belong to checkboxes and radios must not be changed.
				Do not change special characters like '%' or '-' in values, you can change only <span style="color:red;">Alpha-Numeric characters IN VALUES</span>
                which refer to clients' data or clients will not be able to fill and update
				their half completed forms.
				</span>
				This field is for agent(s) who access to backend to obtain a general view
				about related clients or changing some values after contacting with clients
				(via phone or at office for example)to update clients' records.
				</div>
                   
                </th>
                								
                <th width="1%">
						<div style="color:#7ab7f5">All published</div>

                </th>
                <th width="1%">
                   				<div style="color:#7ab7f5">Ordering</div>

                </th>
                <th width="1%">
                    	   <div style="color:#7ab7f5">IDs</div>

                </th>
            </tr>
	    </thead>
		<tfoot>
            <tr>
                <td colspan="10">
                </td>
            </tr>
        </tfoot>
		<tbody>
			<?php
                    $n = count($this->items);
					if(!empty($searched)):
					
					$searchedItems = [];
					for($i=0; $i<$n; $i++):
				    if($issearched && preg_match('/'.$searched.'/i',$this->items[$i]->params))
						$searchedItems [] = $this->items[$i];
					endfor;
					endif;
					
					$lp =  $page;
				
					$lp = intval($lp);
					$lb = $lp+$limit;
					
         if(empty($searched)):
					for($i=$lp; $i<$lb && $i<$n; $i++):   

                        $ordering = ($listOrder == 'a.ordering');
                        $canEdit = true;
                        $canCheckin = true;
                        $canEditOwn = true;
                        $canChange = true;
					    $insuranceclientID = $this->items[$i]->id; 
						
						
						
						$place = strpos($this->items[$i]->params, 'formid');

						$tableid = substr($this->items[$i]->params, $place+8, 1);
						$tableidb = substr($this->items[$i]->params, $place+8, 2);
						$tableidc = substr($this->items[$i]->params, $place+8, 3);
						if(strpos($tableidb, '"')==0)
							$tableid = $tableidb;
						if(strpos($tableidc, '"')==0)
							$tableid = $tableidc;


					    $insurancetableID = trim($tableid);
						$userid = $this->items[$i]->userid;

						if(intval($userid)!==0)
						{
							$db = JFactory::getDbo();
                            $query = $db->getQuery(true);
							$db->setQuery('SELECT name, email, registerDate , lastvisitDate from #__users where id = "'.$userid.'"');
							$result = $db->loadObjectList();
						}

            ?>
					<tr class="row<?php echo $i % 2; ?>">
							<td class="left">
                               <?php echo JHtml::_('grid.id', $i, $insuranceclientID.'_'.$insurancetableID); ?>
                            </td>
							<td style="width:5%; text-align:center">

							
							<textarea name="data_<?php echo  $insuranceclientID.'_'.$insurancetableID ?>" cols="20" rows="5" style="width:400px;resize:vertical;">
							<?php 
							
							echo trim($this->items[$i]->params);
							?>
							</textarea>							
                            </td>
							<td class="center">
                              
								<div style="color:blueviolet">
								
								<?php if(intval($userid)===0):
									echo "<div><strong>tableNumber_clientRecordNumber_userid:</strong></div>";
                                    echo "<div style='color:#7ab5f5;'>".$tableid."_".$insuranceclientID."_".$userid."</div>"; 
							else :
								   echo "<div><strong>Name: ".$result[0]->name;
							       echo ", Email:".$result[0]->email;
								   echo ", Register Date:".$result[0]->registerDate;
								   echo ", lastvisit Date:".$result[0]->lastvisitDate."</strong></div>";
							 
							endif;
							  $files = JFolder::files(JPATH_ADMINISTRATOR.'/components/com_insurance/Fileuploads');
							  if($files!==null && intval($userid)!==0)
							  {
								  foreach($files as $value)
								  {
									  if(preg_match('/'.$tableid.'_'.$userid.'/', $value))
									  {
										  echo 'File uploaded by client:'.$value.'<br />';
										  $ext = JFile::getExt($value);
										  if(preg_match('/\.(gif|jpg|jpeg|png)$/', $value))
										  {
											  echo '<img src="'.JURI::Base().'components/com_insurance/Fileuploads/'.$value.'" width="95px" height="95px" /><br />';
										  }
										  else
										    if(preg_match('/\.(txt|docx|pdf)$/', $value))
										  {
											  echo '<a href="'.JURI::Base().'components/com_insurance/Fileuploads/'.$value.'" >'.$value.'</a><br />';
										  }
										
									  }
								  }
							  }
							?>
								
								</div>

                            </td>
							<td class="order" style="text-align:center">
                              
                               <?php $disabled = $saveOrder ? '' : 'disabled="disabled"'; ?>
                                <input  type="text" name="order[]" size="5" value="<?php echo $this->items[$i]->ordering; ?>" <?php echo $disabled ?> class="text-area-order" style="width:50px" />

                           </td>
						   <td align="center">
                              <?php
							  echo $insuranceclientID;
							  ?>
                           </td>
					</tr>
					
					
					
					
					
					
					<?php 
					endfor; 
					else:
					$n = count($searchedItems);
					for($i=$lp; $i<$lb && $i<$n; $i++):   

                        $ordering = ($listOrder == 'a.ordering');
                        $canEdit = true;
                        $canCheckin = true;
                        $canEditOwn = true;
                        $canChange = true;
					    $insuranceclientID = $searchedItems[$i]->id; 
						
						
						
						$place = strpos($searchedItems[$i]->params, 'formid');

						$tableid = substr($searchedItems[$i]->params, $place+8, 1);
						$tableidb = substr($searchedItems[$i]->params, $place+8, 2);
						$tableidc = substr($searchedItems[$i]->params, $place+8, 3);
						if(strpos($tableidb, '"')==0)
							$tableid = $tableidb;
						if(strpos($tableidc, '"')==0)
							$tableid = $tableidc;


					    $insurancetableID = trim($tableid);
						$userid = $searchedItems[$i]->userid;

						if(intval($userid)!==0)
						{
							$db = JFactory::getDbo();
                            $query = $db->getQuery(true);
							$db->setQuery('SELECT name, email, registerDate , lastvisitDate from #__users where id = "'.$userid.'"');
							$result = $db->loadObjectList();
						}

            ?>
					<tr class="row<?php echo $i % 2; ?>">
							<td class="left">
                               <?php echo JHtml::_('grid.id', $i, $insuranceclientID.'_'.$insurancetableID); ?>
                            </td>
							<td style="width:5%; text-align:center">

							
							<textarea name="data_<?php echo  $insuranceclientID.'_'.$insurancetableID ?>" cols="20" rows="5" style="width:400px;resize:vertical;">
							<?php 
							
							echo trim($searchedItems[$i]->params);
							?>
							</textarea>							
                            </td>
							<td class="center">
                              
								<div style="color:blueviolet">
								
								<?php if(intval($userid)===0):
									echo "<div><strong>tableNumber_clientRecordNumber_userid:</strong></div>";
                                    echo "<div style='color:#7ab5f5;'>".$tableid."_".$insuranceclientID."_".$userid."</div>"; 
							else :
								   echo "<div><strong>Name: ".$result[0]->name;
							       echo ", Email:".$result[0]->email;
								   echo ", Register Date:".$result[0]->registerDate;
								   echo ", lastvisit Date:".$result[0]->lastvisitDate."</strong></div>";
							 
							endif;
							  $files = JFolder::files(JPATH_ADMINISTRATOR.'/components/com_insurance/Fileuploads');
							  if($files!==null && intval($userid)!==0)
							  {
								  foreach($files as $value)
								  {
									  if(preg_match('/'.$tableid.'_'.$userid.'/', $value))
									  {
										  echo 'File uploaded by client:'.$value.'<br />';
										  $ext = JFile::getExt($value);
										  if(preg_match('/\.(gif|jpg|jpeg|png)$/', $value))
										  {
											  echo '<img src="'.JURI::Base().'components/com_insurance/Fileuploads/'.$value.'" width="95px" height="95px" /><br />';
										  }
										  else
										    if(preg_match('/\.(txt|docx|pdf)$/', $value))
										  {
											  echo '<a href="'.JURI::Base().'components/com_insurance/Fileuploads/'.$value.'" >'.$value.'</a><br />';
										  }
										
									  }
								  }
							  }
							?>
								
								</div>

                            </td>
							<td class="order" style="text-align:center">
                              
                               <?php $disabled = $saveOrder ? '' : 'disabled="disabled"'; ?>
                                <input  type="text" name="order[]" size="5" value="<?php echo $searchedItems[$i]->ordering; ?>" <?php echo $disabled ?> class="text-area-order" style="width:50px" />

                           </td>
						   <td align="center">
                              <?php
							  echo $insuranceclientID;
							  ?>
                           </td>
					</tr>
					
					
					
					
					
					
					<?php 
					endfor;
					
					endif;
					?>
					
	    </tbody>

	</table>
	<div>
		   <?php
		   	$pageNav = new JPagination($n , $page, intval($limit));
			
		   echo $pageNav->getListFooter(); 
		   ?>

	</div>
	<div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<input type="hidden" name="recslimit" value="<?php echo $limit ?>">

        <?php echo JHtml::_('form.token'); ?>
    </div>

</form>
<p></p>
 <form action="<?php JRoute::_('index.php?option=com_insurance&view=insuranceclients&limitflag=1'); ?>" method="post" name="limitForm" id="limitForm">
 <label>Input the number of the records you want to view:(input only numbers)</label>
 <input type="text" name="recordslimit" value="" />
 <input type="hidden" name="limitstart" value="0" />
 <input type="submit" name="submitlimit" value="Set Limit For Records">
 </form>
 
 <p></p>
 <form action="<?php JRoute::_('index.php?option=com_insurance&view=insuranceclients'); ?>" method="post" name="searchForm" id="searchForm">
 <label>Input name or email or phone in text box below:(search is not case sensitive)</label>
 <input type="text" name="sclient" value="" />
 <input type="hidden" name="issearched" value="true" />
 <input type="submit" name="search" value="Search">
 </form>
