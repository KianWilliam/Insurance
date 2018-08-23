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
   defined('_JEXEC') or die;
   JHtml::_('jquery.framework');
   jimport('joomla.filesystem.file');
   jimport('joomla.filesystem.folder');
   use Joomla\Utilities\ArrayHelper;
   $jinput = JFactory::getApplication()->input;
   $page	= $jinput->get('limitstart', 0);  
   $data = $jinput->post->getArray();
   $userid = $data['jform']['userid'];
   $table = $data['jform']['formid'];
   $document=JFactory::getDocument();
    $document->addStyleSheet(JURI::Base().'administrator/components/com_insurance/assets/css/agentsresponsive.css');
   $sform = $data['jform']['subsav'];
  
   $db = JFactory::getDbo();
   if($data['jform']['formid']!==null)
   {
     if(!empty($userid))
     {
	 
		     $query = $db->getQuery(true);
			 $query->delete($db->quoteName('#__'.$table))->where($db->quoteName('userid').'='.$db->quote($userid));
			 $db->setQuery($query);
			 $db->execute();
	   
     }
    $query = $db->getQuery(true);

   $columns = array('userid', 'params');
   $data=ArrayHelper::toString($data, '=', ' ', true);
  
   $datalore = array($db->quote($userid), $db->quote($data));
   $query->insert($db->quoteName('#__'.$table))->columns($db->quoteName($columns))->values(implode(',',$datalore));
   $db->setQuery($query);
   $db->execute();
   		  $files = $jinput->files->get('jform');
      
      if($files!==null)
	  {
		  
		  if(!JFolder::exists(JPATH_ADMINISTRATOR.'/components/com_insurance/Fileuploads'))
		  {
			  
			  JFolder::create(JPATH_ADMINISTRATOR.'/components/com_insurance/Fileuploads', 755);
		  }
		 
		  
		  $alreadyloadedfiles = JFolder::files(JPATH_ADMINISTRATOR.'/components/com_insurance/Fileuploads');
		
			  foreach($files as $newfile)
			  {
				  
				  
				  $filename = JFile::makeSafe($newfile['name']);
		          $src = $newfile['tmp_name'];
				  if($alreadyloadedfiles!==null){
					  
                      foreach($alreadyloadedfiles as $value)
		              {
			            if($value === $table.'_'.$userid.'_'.$filename)
			            {
							srand(time());
				          $num = rand(1, 1000);
				          $filename = $num.'_'.$filename;
						  break;
			            }
					  }
				  }
			      $dest = JPATH_ADMINISTRATOR.'/components/com_insurance/Fileuploads/'.$table.'_'.$userid.'_'.$filename;
		          JFile::upload($src, $dest);
			  
			  
		     }
		 
	  }
   
   }
   $app = JFactory::getApplication();
   $activemenu =  $app->getMenu()->getActive()->link;
   
if(trim($sform)==='2' || strpos($activemenu, 'insuranceagents')):
   $query = $db->getQuery(true);
   $query->select('*');
   $query->from('#__insurance_agents');
   
    $limit = $jinput->post->get('limit', 3);
   $db->setQuery($query, $page, $limit);
   $result = $db->loadObjectList();
   
   jimport('joomla.pagination.pagination');
      
      $db->setQuery("Select * From #__insurance_agents");

   $r = $db->loadObjectList();
   
  
   
   $pageNav = new JPagination(count($r) , $page, $limit);
  
 ?>
 <div style="width:93%;color:inherit;margin-left:5px;text-align:justify;">
	You may choose any of below agents to contact and ask your questions, your data is in our database and you will be contacted soon.
	At time it had better to review the information in our website to save your own time. Our Policy is the get the fastest result.
	ALSO if you submitted a ClAIM, rest assured you will be contacted in 4 hours by our agents, this will not be a function of time.
</div>
 <form action="index.php?option=com_insurance&view=insuranceagents" method="post" name="adminForm" id="adminForm" class="agents">

<?php 
   foreach($result as $i=>$value):   
?>	
	<div id="agentrecord" class="clearbreak" style="margin-top:5px;margin-left:5px;width:93%; margin-bottom:5px; height:auto;">
		<div id="image" style="float:left; display:block; padding-right:10px; margin-bottom:5px;"><img src="<?php echo JURI::Base().$value->image ?>" width="150px; max-height:200px" style="border-radius:5px;" /></div>
		<div id="fullname" style="margin-top:">Name:<?php echo $value->fullname; ?></div>
        <div id="phone">Phone:<?php echo $value->phone; ?></div>
		<div id="email">Email:<a href="mailto:<?php echo $value->email; ?>" style="color:inherit;"><?php echo $value->email; ?></a></div>
		<div id="availability">Availability:<?php echo $value->availability; ?></div>
	</div>
<?php
   endforeach;
  
   echo $pageNav->getListFooter(); 
?>
		
        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

</form>
<?php

else:

    echo "Your data is saved in our database, hope to see you soon.";

endif;
?>




  
    


        
    
