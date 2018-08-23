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

defined('JPATH_PLATFORM') or die;

jimport('joomla.form.formfield');

class JFormFieldSample extends JFormField
{
	protected $type = 'Sample';

	protected function getInput()
	{
		return '';
	}

	protected function getLabel()
	{
		$document = JFactory::getDocument();

		$label = '';

		$text = $this->element['label'] ? (string) $this->element['label'] : (string) $this->element['name'];
		$text = $this->translateLabel ? JText::_($text) : $text;
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>Employ the samples here in the textarea below:</div>";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>If your form is only one page DO NOT USE tab at all , just use elements( NO COMMA IN ELEMENT'S DEFINITION USE COMMA ONLY AT THE END OF EACH ELEMENT's DEFINITION), also USE NO NUMBER IN FORM ELEMENT'S NAME. only [a-zA-z] you can separate them with - or _ or space.  <strong>Copy the samples, paste them in the textarea below and then change them based on your form</strong>, use display:block to have a vertical aligned element display and to have horizontal aligned use display:inline-block.</div>";
	    $text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>If using display:inline-block as instructed below, to start a new row first use div protocol with a height specified by yourself.(view sample below)</div>";
	    $text .="<div style='font-size:1.1em;font-weight:bold;color:red'>Also if you want to leave a field empty in an element definition, use a hyphen(-) between the colons.<br />";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>To start a multi-page form:</div>";
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>tab:-:-:-:-:-:-,</div>";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>To have a title with brief explaination: formtitle:title stuff:size of title with no px:brief explanation:-:-:-, </div>";
        $text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>formtitle:Pets and Dogs:12:Secure your dogs and cats from Eagle:-:-:-,</div>";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>After that based on the protocol below type inputs you want in that page:<br />";
		$text .="Always colon (:) between attributes and types and in the end a comma(,) to start a new input or a form page.<br />";
	    $text .="To make an input follow the protocol below: ( no px for width, height and margins)</div>";
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>type:name:placeholder:width:height:label:required@display@marginleft@margintop@width@inputmarginleft@inputmargintop,</div>";
	    $text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>For checkbox the syntax is --> type:name:placeholder:width:height:label:required@checked@marginleft@margintop@width,</div>";
		$text .="A checkbox does not have a placeholder , type it as below:(no display for radio and checkbox just follow the protocol above)<br />";
		$text .="For the last one in a serie (or a single checkbox) put 1 in width place, separate values  with @ in last place:<br />";
		$text .="Type horizontal in place holder of all checkboxes if you want checkboxes to be appeared in one line if not type vertical , for general label use height part.</div> ";
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>checkbox:graduated:horizontal:-:-:Graduated:true@true@10@10@100@0@0,</div>";
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>checkbox:illitrate:horizontal:1:University Degree:Illitrate:true@true@10@10@100@0@0,</div>";		
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>For radio the syntax for the last one in a serie is : -->type:name:placeholder:width:height:label:required@marginleft@margintop@width ,</div>";
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>For radio the syntax for the first one in a serie is : -->type:name:placeholder:width:height:label:checked@width ,</div>";
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>For radios between first and last in a serie is : -->type:name:placeholder:width:height:label:-@width ,</div>";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>To have a group of radio buttons.<br /> ";
		$text .="For the last radio item, divide label part in two divisions, first part main label next part for words next to radio button.<br /> ";
        $text .="e.g Your Pet as main label and  labels next to radios: dog, cat, crow : Your Pet%dog if dog is the last item.<br /> ";
        $text .="In the last place if it is the first radio item: checked@width, for the following items but the last radio item type: -@width and for the last item: required@marginleft@margintop@width. <br />";
		$text .="In placeholder put: vertical or horizontal for all radio items but the last one:</div>";	
        $text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>radio:pets:horizontal:-:-:cat:checked@100,<br />";
		$text .="radio:pets:horizontal:-:-:dog:-@100,<br />";
		$text .="radio:pets:horizontal:-:-:rabbit:-@100,<br />";
		$text .="radio:pets:-:100:29:Your Pet%crow:true@10@10@100,</div>";		
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>To make a text input in the text area type:(for display use only block or inline-block)</div>";
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>text:fname:firstname:100:29:Your First Name:true@block@10@10@100@0@0,</div>";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>Or with display:inlineblock --> text:fname:firstname:100:29:Your First Name:true@inline-block@10@10@100@0@0,</div>";
        $text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>To start a new line after using display:inline-block for several in one row elements:</div>";
	    $text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>div:height:-:-:-:-:-,</div>";        
	    $text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>div:29:-:-:-:-:-,</div>";	
	    $text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>To make a textarea in the below textarea type:</div>";
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>textarea:message:Input message here:299:299:Your Message:true@block@10@10@100@0@0,</div>";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>To have an email input:</div>";
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>email:email:email@email.fr:100:29:Email:true@block@10@10@100@0@0,</div>";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>To have a password input:</div>";
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>password:passw:-:100:29:Password:true@block@10@10@100@0@0,</div>";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>To have a date input:(use placeholder as max or min attribute of input date, for min always use (Before) in label and for max (After) then label content follows after a space)</div>";
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>date:bday:1999-01-01:100:29:(Before) Date:false@block@10@10@100@0@0,<br />";
		$text .="date:aday:1999-01-01:100:29:(After) Date:false@block@10@10@100@0@0,</div>";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>To have both min and max in placeholder separate min%max like this and add (BA) in label and no prefix at all in label when there is no max or min:</div>";
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>date:bday:1999-01-01%2099-01-01:100:29:(BA) Date:false@block@10@10@100@0@0,</div>";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>To have an integer input type:(use place holder to use min,max,step & value attribute and use # between min and max)</div>";
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>number:nums:5#10#5#5:100:29:Number of degrees:false@block@10@10@100@0@0,</div>";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>To have a range input type:(use place holder to use for min and max and use # between min and max)</div>";
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>range:age:15#45:100:29:Range of age:false@block@10@10@100@0@0,</div>";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>To have a url input:</div>";
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>url:homepage:-:100:29:Your Home Page:false@block@10@10@100@0@0,</div>";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>To have a range input:(in place holder first value is for min and second value is for max range.)</div>";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>range:age:15#45:100:29:Range of Ages:false@block@10@10@100@0@0,<br />";
		$text .="To have a select input:(use placeholder to assign option%optionvalue%selected#option%optionvalue#type%multiple)";
        $text .="(add selected to option%optionvalue%selected for the selected one, then the first option always is the selected one in select, also if you want to select mulitple, add multiple if not type regular)<br />";
		$text .="If you do not want these last option just do not add it, the rest will be done for you.</div>";
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>select:cars:Citroen%France%selected#Miniminor%Britain#type%multiple:100:29:Your Home Page:false@block@10@10@100@0@0,</div>";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>To have a file input:(use % to separate placeholder in 2 parts, second one for accept attribute to upload certain file types, separate them with |)</div>";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>If it is meant to upload all types of files then use no % sign and just type placeholder's value.</div>";
		$text .="<div style='font-size:1.4em;font-weight:bold;color:#7ab7f5;'>file:attachfile:File Upload%.gif|.jpg|image/*:100:29:File:true@block@10@10@100@0@0,</div>";
		$text .="<div style='font-size:1.1em;font-weight:bold;color:#008b8b;'>No comma after the last element and use comma ONLY at the end of each element definition never in definition.eg. text:cars,motors,:... shall ruin your form.Also use :(colon) ONLY to separate different attributes for an element. <span style='font-size:1.5em'>Simply copy and paste those samples above in the below textarea and just change the content based on your form</span>.</div>";




		$class = !empty($this->description) ? 'hasTip' : '';
		if ($this->element['class']) {
			$class .= ' ' . $this->element['class'];
		}

		$label .= '<label id="' . $this->id . '-lbl" for="' . $this->id . '" class="' . $class . '" style="width:100% !important;"';

		if (!empty($this->description))
		{
			$label .= ' title="'
				. htmlspecialchars(
				trim($text, ':') . '::' . ($this->translateDescription ? JText::_($this->description) : $this->description),
				ENT_COMPAT, 'UTF-8'
			) . '"';
		}

		if ($this->required)
		{
			$label .= '>' . $text . '<span class="star">&#160;*</span></label>';
		}
		else
		{
			$label .= '>' . $text . '</label>';
		}
		

		return $label;
	}

	protected function getTitle()
	{
		return $this->getLabel();
	}
}


