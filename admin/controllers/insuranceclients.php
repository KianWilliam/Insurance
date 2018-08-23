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
jimport('joomla.application.component.controlleradmin');

class InsuranceControllerInsuranceclients extends JControllerAdmin
{
	public function deleteGama()
	{
					

		  // Check for request forgeries
    JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		
		$input = JFactory::getApplication()->input;
		$cid = $input->get('cid', array(), '', 'array');
		
	if (!is_array($cid) || count($cid) < 1)
    {
		 JFactory::getApplication()->enqueueMessage($this->text_prefix . '_NO_ITEM_SELECTED', 'error');
    }
    else
    {
            
        $model = parent::getModel('Insuranceclients', 'InsuranceModel', array('ignore_request' => true));
		$model->delete($cid);  


    }
		$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list, false));

		
		
	}
	public function saveGama()
	{
		 JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		
		$input = JFactory::getApplication()->input;
		$cid = $input->get('cid', array(), '', 'array');
		$limit = $input->get('recslimit');
		$page = $input->get('limitstart');
		$params = [];
		foreach($cid as $key=>$value)
		{
			$params[] = $input->getString('data_'.$value);

		}
		
		
	if (!is_array($cid) || count($cid) < 1)
    {
				 JFactory::getApplication()->enqueueMessage($this->text_prefix . '_NO_ITEM_SELECTED', 'error');

    }
    else
    {
            
        $model = parent::getModel('Insuranceclients', 'InsuranceModel', array('ignore_request' => true));
		$model->update($cid, $params);      

    }
		$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list . '&limitstart='.$page.'&recslimit='.$limit, false));
	}
}
