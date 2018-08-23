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
   //JHtml::_('bootstrap.framework');
   JHtml::_('jquery.framework');
   jimport( 'joomla.form.form' );
   jimport('joomla.session.session');
   JHtml::_('behavior.tooltip');
   JHtml::_('behavior.formvalidator');
   jimport( 'joomla.registry.registry' );
      use Joomla\Utilities\ArrayHelper;


   $document = JFactory::getDocument();
   $document->addScript('https://www.google.com/recaptcha/api.js');
   $document->addStyleSheet(JURI::Base().'administrator/components/com_insurance/assets/css/formresponsive.css');

   $user = JFactory::getUser();
  
   $userid =$user->id;
	
   $input = JFactory::getApplication()->input;
   $flag = $input->get('flag');
   $params = $input->get('title');
   $p = $params;  
   $row="";


   
   JPluginHelper::importPlugin('content');
   $dispatcher = JEventDispatcher::getInstance(); 
?>	
         <div id="insuranceformholder" class="insuranceformholder">
		 
		 <form name="insuranceform" action=""  method="post" id="insuranceform" class="insuranceform" enctype="multipart/form-data" autocomplete="off"> 

		 <?php 
		       $result = $dispatcher->trigger('onContentPrepare', array('com_insurance.insuranceform', &$row, &$params,0) );
			
		 ?>
		 <div class="buttonholder">
           <div>
		<?php 
		
		  if(intval($result[0]) == 2){	 
            echo '<input type="button" id="prevBtn" name="jform[previous]"  value="Previous" />';
            echo '<input type="button" id="nextBtn" name="jform[next]"   value="Next" />';        
		  }else{
		    echo '<input type="button" id="submitform" name="jform[submit]"   value="Submit" />'; 	
		    echo '<input type="reset" id="resetform" name="jform[reset]"   value="Reset" />';		 
			
		  }
		  
		  if($userid!==0 && strpos($params->get('form_url'), 'view=insuranceagents'))
		      echo '<input type="button" id="saveform" name="jform[submit]"   value="Save Form" />'; 		 

		  
		  ?>
		  </div>
         </div>
		  <input type="hidden" name="jform[]" value="test">
	      <input type="hidden" name="jform[userid]" value="<?php echo $userid ?>">
		  <input type="hidden" name="jform[formid]" value="<?php echo $p ?>"> 
		  <input type="hidden" name="jform[subsav]" id="subsave" value="">	
		  
		 </form>
		 
         </div>
		 <div style="float:left;text-align:justify;padding:5px;width:98%;">
		 To be serviced better, We advise you to register first
		 so that our agents will be able to pursue your task faster and easier.
		 <?php if(strpos($params->get('form_url'), 'insuranceagents')): ?>
		 To save a half-filled form you have fill all elements in that particular page.
		 <a href="<?php echo JURI::current(); ?>?flag=1&title=<?php echo $p; ?>"> If you would like to fill the rest of the form you already filled partly, click here</a>
		 <div>This option is only for registered users who log into their accounts. You may use the form without registration, if you do not register, your data will be available to us but you can not update 
		 you data at a later time. Better to register first, you will be able to update your record.</div></div>
		 <?php endif; ?>
<?php 

if($flag==1)
{

   if($userid)
   {
	  
	   $table = $input->get('title');
	   JPluginHelper::importPlugin('binddata');
       $dispatcher = JEventDispatcher::getInstance(); 
	   $data = $dispatcher->trigger('onReadDataToBind', array(&$table, &$userid) );
	   
		   
$bindparams = $data[0][0]->params;

$bindparams =str_replace('" ', '",', $bindparams);
$abindparams = explode(',', $bindparams);

foreach($abindparams as $key=>&$value)
{
	$value = '"jform['.$value;
	$value = str_replace('=', ']":', $value);
}
$abindparams = implode(',', $abindparams);
$abindparams = "{".$abindparams."}";

$abindparams = preg_replace('/\{"jform\[\s+/','{"jform[', $abindparams);

	  $d = json_decode($abindparams, TRUE);
	  
	  
	  foreach($d as $key => $value)
	  {
		  if(preg_match('/\[jform/', $key, $match))
		  {
			  $oldkey = $key;
              $newkey = preg_replace('/\[jform\s+/', '[', $key);
			  $d[$newkey]=$d[$key];
			  unset($d[$key]);
		  }
		  
	  }
	  
	  
	   
	   
	    $binddata="
		jQuery(document).ready(function(){
		var data = {};
			data = ".json_encode($d).";
			var inputval;
			var selectnamenum;
            var val = [];
		jQuery.each(data, function(key, value)
		{
			jQuery('input[type=text][name=\"'+key+'\"]').val(value);
			jQuery('input[type=date][name=\"'+key+'\"]').val(value);
			jQuery('input[type=number][name=\"'+key+'\"]').val(value);
			jQuery('input[type=url][name=\"'+key+'\"]').val(value);
			jQuery('input[type=email][name=\"'+key+'\"]').val(value);
			jQuery('input[type=range][name=\"'+key+'\"]').val(value);
		
			if(value==='false')
			{
		
				jQuery('input[type=checkbox][name=\"'+key+'\"]').prop('checked', false);

			}			
			if(value === 'true')
			{
			    jQuery('input[type=checkbox][name=\"'+key+'\"]').prop('checked', true);
			}

			jQuery('textarea[name=\"'+key+'\"]').val(value);

			
				for(var i=0; i<jQuery('input[type=radio][name=\"'+key+'\"]').length; i++)
				{
					if(jQuery('input[type=radio][name=\"'+key+'\"]').eq(i).val()===value)
									 jQuery('input[type=radio][name=\"'+key+'\"]').eq(i).prop('checked', true);									
				}
			

			if(key.test(/(\w+)\s0/) || (key.test(/^jform\[[1-9]*\]$/) && value!=='test'))
			{
				if(key.indexOf('0')!==0 && key.indexOf('0')!==-1){
					selectnamenum = key.split(' ');	
                } 
			        for( i=0; i<jQuery('select[name=\"'+selectnamenum[0]+'][]\"]').children().length; i++)
					{
						if(value===jQuery('select[name=\"'+selectnamenum[0]+'][]\"]').children().eq(i).val())
						{
							jQuery('select[name=\"'+selectnamenum[0]+'][]\"]').children().eq(i).prop('selected', true);
						}
					}
				
				
			}


		});
		})";
		$document->addScriptDeclaration($binddata);
   }
   else
   {
	   echo "You have to login or register to view your data in form!";
   }
}

?>
<script type="text/javascript">
 jQuery(document).ready(function(){
 
 	jQuery('#insuranceform').attr('action', '<?php echo $params->get('form_url'); ?>');

	 
	 if(jQuery("#insuranceform div").hasClass("tab"))
	 {
       var currentTab = 0; 
       showTab(currentTab); 
	 }
	 
     jQuery('input[type=checkbox]').click(function(){
		 if(jQuery(this).prop('checked'))
		 {
			 
			  jQuery(this).val('true');
		 }

	 });


   function showTab(n) {
  
		
	   jQuery(".tab").eq(n).css({display:"block"});
  
       if (n == 0) {
		jQuery("#prevBtn").css({display:"none"})
       } else {
				jQuery("#prevBtn").css({display:"inline"})

       }
  if (n == (jQuery(".tab").length - 1)) {
   		jQuery("#nextBtn").val("Access Your Quote")

  } else {
   		jQuery("#nextBtn").val("Next")

	}  
}

function nextPrev(n) {
  
 
if(jQuery("#insuranceform div").hasClass("tab"))
	  jQuery(".tab").eq(currentTab).css({display:"none"});

  
  
  
 if(jQuery("#insuranceform div").hasClass("tab"))
 {
	  if (n == 1 && !validateForm())
	  {
		  jQuery(".tab").eq(currentTab).css({display:"block"});
		  return false;
		  
	  }

      currentTab = currentTab + n;

  if (currentTab >= jQuery(".tab").length) {
	    		 		 jQuery('#subsave').val('2');
     if('<?php echo $params->get('recaptcha')?>'=='true'){       
			 var cap1 = grecaptcha.getResponse();
         if(cap1.length ==0 )
         {
         alert('click re-captcha');
          showTab(currentTab-1);
			 return false;
		 }
		 else
		 {			 
	  		   jQuery("#insuranceform").submit();
	           return true;
         }
         }
         else
         {
         	  jQuery("#insuranceform").submit();
	           return true;
         }
	
  }
 }
 else
 {
	 if(validateForm())
	 {
		 		 jQuery('#subsave').val('2');
      if('<?php echo $params->get('recaptcha')?>'=='true'){		 		 
         var cap2 = grecaptcha.getResponse();
         
         if(cap2.length == 0)
         {
          alert('click re-captcha');
			return false;
		 }
		 else
		 {
	         jQuery("#insuranceform").submit();
	         return false;
		 }
		 }
		 else
		 {
		  jQuery("#insuranceform").submit();
	         return false;

		 }
	 }
	 else
	 {
		 return false;
	 }
	 
 }
 
if(jQuery("#insuranceform div").hasClass("tab"))
    showTab(currentTab);
 }

function validateForm() {
  
  var x, y, i, valid = true;

  if(jQuery("#insuranceform div").hasClass("tab"))
  {
    var inputs = jQuery('.tab').eq(currentTab).find('input');
    var selects = jQuery('.tab').eq(currentTab).find('select');
	var textareas = jQuery('.tab').eq(currentTab).find('textarea');
  }
  else
  {
	   var inputs = jQuery('#insuranceform').find('input');
       var selects = jQuery('#insuranceform').find('select');
	   var textareas = jQuery('#insuranceform').find('textarea');
  }
 
  for (i = 0; i < inputs.length; i++) {
    
	switch(inputs.eq(i).attr("type"))
	{
		case "text":
			if (inputs.eq(i).val() == "" && inputs.eq(i).attr("required"))
			{ 
				inputs.eq(i).css({backgroundColor:"#ffcccc"});
				alert("Field is empty!");
				valid = false;
            }
			else
			if(inputs.eq(i).val() == "" && !inputs.eq(i).attr("required"))
			{
			}
            else
		      if(!inputs.eq(i).val().match(/[A-Za-z0-9_-]/) )
		      {
			    inputs.eq(i).css({backgroundColor:"#ffcccc"});
			    alert("You are using not allowed characters in this field!");
			    valid=false;
		      }	
			
		break;
		case "password":
		if(inputs.eq(i).val() == "" && inputs.eq(i).attr("required"))
		{
			inputs.eq(i).css({backgroundColor:"#ffcccc"});
			inputs.eq(i).val("Password is empty!");
			valid=false;
		}
		else
			if(inputs.eq(i).val() == "" && !inputs.eq(i).attr("required"))
			{
			}
            else
		      if(!inputs.eq(i).val().test(/((?=.*d)(?=.*[a-z])(?=.*[A-Z]).{8,15})/gm) )
		      {
			    inputs.eq(i).css({backgroundColor:"#ffcccc"});
                alert("Password should be from 8 to 15 characters with at least one uppercase!");
			    valid=false;
		      }		
		break;
		case "email":
		if(inputs.eq(i).val() == "" &&  inputs.eq(i).attr("required"))
		{
			inputs.eq(i).css({backgroundColor:"#ffcccc"});
			alert("Field is empty!");
			valid=false;
		}
		else
			if(inputs.eq(i).val() == "" && !inputs.eq(i).attr("required"))
			{
			}
            else
		    if(!inputs.eq(i).val().test(/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i) )
		    {
			  inputs.eq(i).css({backgroundColor:"#ffcccc"});
			  alert("Fix email pattern!");
			  valid=false;
		    }
		break;
		case "range":
		break;
		case "number":
		if (inputs.eq(i).val() == "" && inputs.eq(i).attr("required"))
			{ 
				inputs.eq(i).css({backgroundColor:"#ffcccc"});
				alert("Field is empty!");
				valid = false;
            }
			else
			if(inputs.eq(i).val() == "" && !inputs.eq(i).attr("required"))
			{
			}
            else
		    if(!inputs.eq(i).val().test(/[0-9 -()+]+$/) )
		    {
			  inputs.eq(i).css({backgroundColor:"#ffcccc"});
			  alert("Only intengers!");
			  valid=false;
			}
			
		break;
		case "date":
		if(inputs.eq(i).val()=="" && inputs.eq(i).attr("required"))
		{			
			inputs.eq(i).css({backgroundColor:"#ffcccc"});
			alert("Select a date!");
			valid=false;
		}
		 
		break;
		case "url":
		if(inputs.eq(i).attr("value") == "" && inputs.eq(i).attr("required"))
		{
			inputs.eq(i).css({backgroundColor:"#ffcccc"});
			alert("Field is empty!");
			valid=false;
		}
		else
			if(inputs.eq(i).attr("value") == "" && !inputs.eq(i).attr("required"))
			{
			}
            else
		    if(!inputs.eq(i).val().test(/^(https?:\/\/)?([da-z.-]+).([0-9a-z.]{2,10})([\/w .-]*)*\/?$/))
		    {
			 inputs.eq(i).css({backgroundColor:"#ffcccc"});
			 alert("Fix Url pattern!");
			 valid=false;
		    }
		break;
		case "file":
		var extensions  = inputs.eq(i).attr('accept');
		if(inputs.eq(i).attr("value") == "" && inputs.eq(i).attr("required"))
		{
			inputs.eq(i).css({backgroundColor:"#ffcccc"});
			alert("File Field is empty!");
			valid=false;
		}
		else
			if(inputs.eq(i).attr("value") == "" && !inputs.eq(i).attr("required"))
			{
			}
            else
		if(!inputs.eq(i).val().indexOf(extensions))
		{
			inputs.eq(i).css({backgroundColor:"#ffcccc"});
			alert("The file extension is not permitted!");
			valid=false;
		}
		break;		
	}
    
  }
 
  for (i = 0; i < textareas.length; i++) {
	  if (textareas.eq(i).val() == "" && textareas.eq(i).attr("required"))
			{ 
				textareas.eq(i).css({backgroundColor:"#ffcccc"});
				alert("Address Field is empty!");
				valid = false;
            }
			else
			if(textareas.eq(i).val() == "" && !textareas.eq(i).attr("required"))
			{
			}
            else
		      if(!textareas.eq(i).val().match(/[A-Za-z0-9_-]/) )
		      {
			    textareas.eq(i).css({backgroundColor:"#ffcccc"});
			    alert("You are using not allowed characters in this field!");
			    valid=false;
		      }	
  }
  
  
 
  return valid; 
}

jQuery("#saveform").click(function(){

	if(validateForm())
	 {
		 jQuery('#subsave').val('1');
	    jQuery("#insuranceform").submit();
	    return false;
	 }
	 else
	 {
		 return false;
	 }
	
})



if(jQuery("#insuranceform div").hasClass("tab")){
jQuery("#nextBtn").click(function(){nextPrev(1)});
jQuery("#prevBtn").click(function(){nextPrev(-1)});
}
else
{
jQuery("#submitform").click(function(){nextPrev(121)})
}
jQuery("#insuranceform input, #insuranceform textarea").change(function(){
	jQuery(this).css({backgroundColor:"<?php echo $params->get('input_backcolor')?>"})
})


   });

 jQuery(window).load(function(){
						if(jQuery('.tab').eq(0).css('float')=='left')
						{
							jQuery('.progress').css({marginLeft:""+<?php echo $params->get("progressbar_margin") ?>+"px"})
						}
						else
						{
							jQuery('.progress').css({marginRight:""+<?php echo $params->get("progressbar_margin") ?>+"px"})
						}
						if(jQuery('.buttonholder').css('float')=='left')
						{
							jQuery('.buttonholder').css('padding-left', '5px');
						}
						else
						{
                           jQuery('.buttonholder').css('padding-right', '5px');
						}
						
						
					});
</script>
  
  