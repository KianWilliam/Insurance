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
jimport('joomla.application.component.view');

class InsuranceViewInsuranceform extends JViewLegacy
{
	protected $state;
	protected $item;
	protected $form;
	protected $isNew = true;
	
	public function display($tpl = null)
	{
		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');
		$this->isNew	= ($this->item->id == 0);
		
		if (count($errors = $this->get('Errors'))) {
			
			JFactory::getApplication()->enqueueMessage('Internal Server Error 500 ','Failure');
			return false;
		}
		
		 $this->addToolbar();
		 parent::display($tpl);
		
	}
	
	protected function addToolbar()
	{
		
		 $h = JFactory::getApplication()->input;
		 $h->set('hidemainmenu', true);
		$title = JText::_('COM_INSURANCE')." - ";
		if($this->isNew)
			$title .= '<small>[ ' . JText::_( 'COM_INSURANCE_NEW' ).' ]</small>'; 
		else 
			$title .= $this->item->title." <small>[".JText::_("COM_INSURANCE_EDIT_SETTINGS")."]</small>";
		
		JToolBarHelper::title($title   , 'generic.png' );
		if ($this->isNew){
			JToolBarHelper::apply('insuranceform.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('insuranceform.save', 'JTOOLBAR_SAVE');
			JToolBarHelper::cancel('insuranceform.cancel', 'JTOOLBAR_CANCEL');
		}
		else {
			JToolBarHelper::apply('insuranceform.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('insuranceform.save', 'JTOOLBAR_SAVE');
			JToolBarHelper::cancel('insuranceform.cancel', 'JTOOLBAR_CANCEL');
		}
	}
	
	
}


