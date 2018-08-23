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

JText::script('COM_INSURANCE_SELECT_IMAGE_LABEL');
JText::script('COM_INSURANCE_SELECT_IMAGE_DESC');
JText::script('COM_INSURANCE_SELECT_IMAGE_TEXT_LABEL');
JText::script('COM_INSURANCE_SELECT_IMAGE_TEXT_DESC');
JText::script('COM_INSURANCE_SELECT_SLIDESHOW_REMOVE_LABEL');


jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldMyformsmanager extends JFormField {
	
	protected $type = 'myformsmanager';
	
	protected function getInput() {

		$document = JFactory::getDocument();
		$document->addScriptDeclaration("JURI='" . JURI::root() . "'");
		$path = 'administrator/components/com_insurance/models/fields/myforms/';
		JHTML::_('behavior.modal');		
		JHTML::_('stylesheet', $path . 'forms.css');
		JHTML::_('script', $path . 'forms.js');
		$html = '<input name="' . $this->name . '" id="myforms" type="hidden" value="' . $this->value . '" />'
				. '<input name="myaddform" id="myaddform"  type="button" value="' . JText::_('COM_INSURANCE_ADDFORM') . '"  onclick="javascript:addformmy();" />'
				. '<ul id="myformlist" style="clear:both;"></ul>'
				. '<input name="myaddform" id="myaddform" type="button" value="' . JText::_('COM_INSURANCE_ADDFORM') . '"  onclick="javascript:addformmy();" />';

		return $html;
	}
		
	protected function getLabel()
	{
		return $this->label;
	}
}




