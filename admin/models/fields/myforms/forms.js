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


var counter = 1;

var imgthumb;
var imgname;
var imgtext;

function jInsertEditorText(text, editor) {
	var newEl = new Element('span').set('html', text);
	var valeur = newEl.getChildren()[0].getAttribute('src');
	$(editor).value = valeur;
	addthumbnail(valeur, editor);
}


function addformmy(imgname, imgthumb, imgtext)
{

	var myform = new Element('li', {
		'class': 'myform',
		'id': 'myform' + counter
	});
	
	myform.set('html', '<div class="myformhandle"><div class="mytabnumber">Tab Number: ' + counter + '</div></div>'+
	'<div class="del"><input name="mytabdelete' + counter + '" class="mytabdelete" type="button" value="' + Joomla.JText._('COM_TAB_REMOVE', 'RemoveTab') + '" onclick="javascript:removetab(this.getParent().getParent());" />'+
	'<input name="myslideimgname' + counter + '" id="myslideimgname' + counter + '" class="myslideimgname hasTip" title="Image::This is the main image for the slide, it will also be used to create the thumbnail" type="text" value="'+imgname+'" onchange="javascript:addthumbnail(this.value, this);" />'+
    '<a class="modal" href="' + JURI + 'administrator/index.php?option=com_media&view=images&tmpl=component&e_name=myslideimgname' + counter + '" rel="{handler:\'iframe\', size:{x: 570, y: 400}}" >' + Joomla.JText._('COM_BORGGIQUE_SELECTIMAGE', 'select image') + '</a>'+
	'</div>'+
    '<div class="explanation"><textarea name="myslidetext' + counter + '"  class="myslidetext">'+imgtext+'</textarea></div><div style="color:red; font-weight:bold;">SELECT AT LEAST 8 IMAGES, total number of images MUST BE divisble by 4! also precede special characters in textarea with backslash(\\)</div>');
	
	document.id('myslideslist').adopt(slide);
	storeslide();
	makesortables();
	SqueezeBox.initialize({});
	SqueezeBox.assign(slide.getElement('a.modal'), {
		parse: 'rel'
	});	

	counter++;
}

function storeslide()
{

	var i = 0;
	var slides = new Array();
	document.id('myslideslist').getElements('.myslide').each(function(el) {
		slide = new Object();
		slide['imgname'] = el.getElement('.myslideimgname').value;		
		slide['imgthumb'] = el.getElement('img').src;
		slide['imgtext']=el.getElement('.myslidetext').value;		
		slides[i] = slide;
		i++;
	});

	slides = JSON.encode(slides);	
	slides = slides.replace(/"/g, "|qq|");
	document.id('myslides').value = slides;
	

}

function makesortables() {
	var sb = new Sortables('myslideslist', {
		/* set options */
		clone: true,
		revert: true,
		handle: '.myslidehandle',
		/* initialization stuff here */
		initialize: function() {

		},
		/* once an item is selected */
		onStart: function(el, clone) {
			el.setStyle('background', '#add8e6');
			clone.setStyle('background', '#ffffff');
			clone.setStyle('z-index', '1000');
		},
		/* when a drag is complete */
		onComplete: function(el) {
			el.setStyle('background', '#fff');
			//storesetwarning();
		},
		onSort: function(el, clone) {
			clone.setStyle('z-index', '1000');
		}
	});
}

function addthumbnail(imgsrc, editor) {
	var slideimg = $(editor).getParent().getElement('img');
	var testurl = 'http';
	if (imgsrc.toLowerCase().indexOf(testurl.toLowerCase()) != -1) {
		slideimg.src = imgsrc;
	} else {
		slideimg.src = JURI + imgsrc;
	}

	slideimg.setProperty('width', '64px');
	slideimg.setProperty('height', '64px');
}

function removeslide(slide) {
	if (confirm(Joomla.JText._('COM_BORGGIQUE_REMOVE', 'Remove this slide') + ' ?')) {
		slide.destroy();
		counter--;
		storeslide();
	}
}

function callslides() {
	
	var slides = JSON.decode(document.id('myslides').value.replace(/\|qq\|/g, "\""));
	if (slides) {
		slides.each(function(slide) {
			addslidemy(slide['imgname'],
					slide['imgthumb'],
					slide['imgtext']
					);
		});
		
	}
}


window.addEvent('domready', function() {
	callslides();

	var script = document.createElement("script");
	script.setAttribute('type', 'text/javascript');
	script.text = "Joomla.submitbutton = function(task){"
			+ "storeslide();"
			+ "if (task == 'borggique.cancel' || document.formvalidator.isValid(document.id('borggique-form'))) {	Joomla.submitform(task, document.getElementById('borggique-form'));"
			+ "if (self != top) {"
			+ "window.top.setTimeout('window.parent.SqueezeBox.close()', 1000);"
			+ "}"
			+ "} else {"
			+ "alert('Formulaire invalide');"
			+ "}}";
	document.body.appendChild(script);
});

