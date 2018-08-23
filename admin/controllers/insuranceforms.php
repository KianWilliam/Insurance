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
class InsuranceControllerInsuranceforms extends JControllerAdmin
{
	public function getModel($name = 'Insuranceform', $prefix = 'InsuranceModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		
		return $model;
	}
	public function deleteOmega()
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
        // Get the model.
		
        $model = $this->getModel();

        // Make sure the item ids are integers
        jimport('joomla.utilities.arrayhelper');
        JArrayHelper::toInteger($cid);

        // Remove the items.
        if ($model->delete($cid))
        {
            $this->setMessage(JText::plural($this->text_prefix . '_N_ITEMS_DELETED', count($cid)));
			 JPluginHelper::importPlugin('content');
               $dispatcher = JEventDispatcher::getInstance();
			   $dispatcher->trigger('onContentAfterDelete', array('com_insurance.insuranceforms',  &$cid));
        }
        else
        {
            $this->setMessage($model->getError());
        }

    }
		$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list, false));

		
		
	}
}
?>

