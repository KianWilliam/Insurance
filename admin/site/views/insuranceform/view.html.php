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
	function display($tpl = null)
	{
		$app		= JFactory::getApplication();
		   
		$item		= $this->get('Item');
		$state		= $this->get('State');		
		$this->assignRef('item', 		$item);
		$this->assignRef('state', 		$state);
		$active	= $app->getMenu()->getActive();
		if ((!$active) || ((strpos($active->link, 'view=insuranceform') === false) || (strpos($active->link, '&id=' . (string) $this->item->id) === false))) {
			
		}
		elseif (isset($active->query['layout'])) {
			$this->setLayout($active->query['layout']);
			}
			
			$this->_prepareDocument();
			
		parent::display($tpl);

	}
	protected function _prepareDocument()
	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
		$title 		= null;
		$menu = $menus->getActive();
		
		
		
		if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}
		if (empty($title)) {
			$title = $this->item->title;
		}
		$this->document->setTitle($title);
	}
}