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
jimport('joomla.session.session');  
JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');


$user = JFactory::getUser();
$userId = $user->get('id');

$db = JFactory::getDbo();
$db->setQuery('SELECT id FROM #__insurance ORDER BY id DESC');
$result = $db->loadObjectList();


$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$canOrder = true; 
$saveOrder = $listOrder == 'a.ordering';
$input = JFactory::getApplication()->input;
$session = JFactory::getSession();

     
		if($session->get('layout')=='edit' && intval($result[0]->id) )
		{

			 $session->set('myid', $result[0]->id);
			
		 JPluginHelper::importPlugin('extension');
         $dispatcher = JEventDispatcher::getInstance();
         $dispatcher->trigger('onExtensionAfterSave',array('com_insurance', $session, true));
		 $session->clear('option');
		 $session->clear('layout');
		 $session->clear('myid');

		}
	 
			


if(intval($input->get('data'))===1)
{
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
			$tablename = trim($input->get('id'));
			
          	$query->select('*');
			$query->from($db->quoteName('#__'.$tablename));
			$db->setQuery($query);
            $result = $db->loadObjectList();

		if(count($result)!=0)
		{	
			$downloadfile = fopen(JPATH_ADMINISTRATOR.'\components\com_insurance\views\insuranceforms\tmpl\downloadfile.txt', 'w+');
			for($i=0; $i<count($result); $i++)
			{
				$res = $result[$i]->id.' ';
				$res .= $result[$i]->userid.PHP_EOL;
				$res .= $result[$i]->params.PHP_EOL;

			    fwrite($downloadfile, $res);
			}

 
 
        while (@ob_end_clean())
		{
			;
		}
				
		$filename =JPATH_ADMINISTRATOR.'\components\com_insurance\views\insuranceforms\tmpl\downloadfile.txt';    
		@clearstatcache();
		// Send MIME headers
		header('MIME-Version: 1.0');
		header('Content-Disposition: attachment; filename='.$filename.'');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');
		header('Content-Type: application/octet-stream; charset=utf-8');
        header('Content-Length: ' . @filesize($filename));
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Expires: 0");
		header('Pragma: no-cache');
		
		flush();

		
       $blocksize = 1048576; //1M chunks
		$handle    = @fopen($filename, "r");
		if ($handle !== false)
		{
			while (!@feof($handle))
			{
				
				echo @fread($handle, $blocksize);
				@ob_flush();
				flush();
			}
		}

		if ($handle !== false)
		{
			@fclose($handle);
		}
		exit;
		
		}
		else
			echo "File is empty, nothing to be downloaded, just wait so that some clients will view your site and input data into your form!";

}

?>

<script type="text/javascript">
	
	
   Joomla.submitbutton = function(task)
    {
        if (task == 'insuranceforms.deleteOmega')
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

<form action="<?php echo JRoute::_('index.php?option=com_insurance&view=insuranceforms'); ?>" method="post" name="adminForm" id="adminForm">

	<div class="clr"> </div>
	<table class="adminlist">
		<thead>
		    <tr>
                <th width="1%" align="left">
                    <input type="checkbox" name="checkall-toggle" value="" onclick="Joomla.checkAll(this)" />
                </th>
                <th width="1%">
                    <?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
                </th>
                								
                <th width="1%">
                    <?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.published', $listDirn, $listOrder); ?>
                </th>
                <th width="1%">
                    <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
                    <?php if ($canOrder && $saveOrder) : ?>
                        <?php echo JHtml::_('grid.order', $this->items, 'filesave.png', 'items.saveorder'); ?>
                    <?php endif; ?>
                </th>
                <th width="1%">
                    <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                </th>
            </tr>
	    </thead>
		<tfoot>
            <tr>
                <td colspan="10">
                     <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
		<tbody>
			<?php
                    $n = count($this->items);
                    foreach ($this->items as $i => $insuranceform) :
                        $ordering = ($listOrder == 'a.ordering');
                        $canCreate = true;
                        $canEdit = true;
                        $canCheckin = true;
                        $canEditOwn = true;
                        $canChange = true;
                        $insuranceformID = $insuranceform->id;                        
                        $title = $this->escape($insuranceform->title);
            ?>
					<tr class="row<?php echo $i % 2; ?>">
							<td class="left">
                               <?php echo JHtml::_('grid.id', $i, $insuranceformID); ?>
                            </td>
							
							<td style="width:5%; text-align:center">
                                <a href="<?php echo JRoute::_('index.php?option=com_insurance&task=insuranceform.edit&id='.(int) $insuranceform->id); ?>"><?php echo $title ?></a>
                                <p class="smallsub">
                                <?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($insuranceform->alias)); ?>
                                </p>
                            </td>
                            <td class="center">
                                <?php echo JHtml::_('jgrid.published', $insuranceform->published, $i, 'insuranceforms.', true, 'cb'); ?>
                            </td>
							<td class="order" style="text-align:center">
                               <?php if ($canChange) : ?>
                               <?php if ($saveOrder) : ?>
                                <?php if ($listDirn == 'asc') : ?>
                                    <span><?php echo $this->pagination->orderUpIcon($i, ($insuranceform->ordering == @$this->items[$i - 1]->ordering), 'insuranceforms.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                    <span><?php echo $this->pagination->orderDownIcon($i, $n, ($insuranceform->ordering == @$this->items[$i + 1]->ordering), 'insuranceforms.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                <?php elseif ($listDirn == 'desc') : ?>
                                    <span><?php echo $this->pagination->orderUpIcon($i, ($insuranceform->ordering == @$this->items[$i - 1]->ordering), 'insuranceforms.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                    <span><?php echo $this->pagination->orderDownIcon($i, $n, ($insuranceform->ordering == @$this->items[$i + 1]->ordering), 'insuranceforms.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                <?php endif; ?>
                               <?php endif; ?>
                               <?php $disabled = $saveOrder ? '' : 'disabled="disabled"'; ?>
                                <input  type="text" name="order[]" size="5" value="<?php echo $insuranceform->ordering; ?>" <?php echo $disabled ?> class="text-area-order" />
                             <?php else : ?>
                                <?php echo $insuranceform->ordering; ?>
                             <?php endif; ?>
                           </td>
						   <td align="center">
                              <?php echo $insuranceform->id; ?><br />
							  <a class="btn"  href="index.php?option=com_insurance&view=insuranceforms&id=<?php echo $insuranceform->id ?>&data=1" >Download Data</a>
                           </td>
					</tr>
					<?php endforeach; ?>
	    </tbody>

	</table>
	<div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>

</form>

  