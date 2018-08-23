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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$graphID = $this->item->id;
$document = JFactory::getDocument();
$backstyles = "
.view-insuranceagent  label
{
	width:242px !important;	
}
";
//$document->addStyleDeclaration($backstyles);
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'insuranceagent.cancel' || document.formvalidator.isValid(document.id('insuranceagent-form'))) {
			Joomla.submitform(task, document.getElementById('insuranceagent-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('COM_INSURANCE_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_insurance&view=insuranceagent&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="insuranceagent-form" class="form-validate">
               <div class="width-60 fltlft">
				    <fieldset class="adminform">
						<legend><?php echo empty($this->item->id) ? JText::_('COM_INSURANCE_NEW') : JText::sprintf('COM_INSURANCE_INSURANCEAGENT_SETTINGS', $this->item->id); ?></legend>
						<ul class="adminformlist">
								<li><?php echo $this->form->getLabel('fullname'); ?>
				                <?php echo $this->form->getInput('fullname'); ?></li>

     			                <li><?php echo $this->form->getLabel('published'); ?>
				                <?php echo $this->form->getInput('published'); ?></li>				             

				                <li><?php echo $this->form->getLabel('id'); ?>
				                  <?php echo $this->form->getInput('id'); ?></li>	

								<li><?php echo $this->form->getLabel('email'); ?>
				                <?php echo $this->form->getInput('email'); ?></li>

     			                <li><?php echo $this->form->getLabel('phone'); ?>
				                <?php echo $this->form->getInput('phone'); ?></li>				             

				                <li><?php echo $this->form->getLabel('image'); ?>
                               <?php echo $this->form->getInput('image'); ?></li>
							   
							     <li><?php echo $this->form->getLabel('availability'); ?>
                               <?php echo $this->form->getInput('availability'); ?></li>								 
						</ul>
						
					</fieldset>
			   </div>
			   <div class="width-40 fltrt">                       
			   <input type="hidden" name="task" value="" />
	               <?php echo JHtml::_('form.token'); ?>			   
			   </div>
			   
</form>
