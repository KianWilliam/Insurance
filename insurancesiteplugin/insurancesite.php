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

use Joomla\Registry\Registry;
JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_insurance/models');
jimport('joomla.session.session');


class PlgContentInsurancesite extends JPlugin
{
		public function onContentPrepare($context, &$row, &$params, $page = 0)
		{

			if($context=="com_insurance.insuranceform")
			{
							   

    			 $db = JFactory::getDbo();
				 $document = JFactory::getDocument();
				 $query = $db->getQuery(true);
			     $query->select($db->quoteName(array('params')));

                 $query->from($db->quoteName('#__insurance'));
                 $query->where($db->quoteName('id')." = ".$db->quote($params));
                 $db->setQuery($query);
                 $results = $db->loadObjectList();
                 $params = new JRegistry;
		         $params->loadString($results[0]->params);
				 
				 if($params->get('jqlib')==1)
					 $document->addScript(JURI::Root().'components/com_insurance/assests/js/jquery-3.3.1.min.js');
				 
				 $formurl = $params->get('form_url');
				 $session = JFactory::getSession();
				$session->set('redirecturl', $formurl);
						 				 

				 
				 $formstyle = "
				 .insuranceformholder
				 {
					 float:left;
					 width:100%;
				 }
				
					.insuranceform 
					{
						width:".$params->get("form_width")."%;
						height:auto;
						font-size:".$params->get("form_fontsize")."px;
						background-color:".$params->get("form_backcolor").";
						font-family:".$params->get("form_fontfamily").";
						font-style:".$params->get("form_fontstyle").";
						font-weight:".$params->get("form_fontweight").";
						padding-left:2px;
					}
					.insuranceform  input[type='radio'],
					.insuranceform  select,
					.insuranceform  input[type='text'],
					.insuranceform  input[type='email'],
					.insuranceform  input[type='password'],
					.insuranceform  input[type='number'],
					.insuranceform  input[type='date'],
					.insuranceform  input[type='url'],
					.insuranceform  textarea,
					.insuranceform  input[type='checkbox'],
					.insuranceform  input[type='range']
					{
						background-color:".$params->get("input_backcolor").";
						border:".$params->get("input_border")."px;
						border-color:".$params->get("input_bordercolor").";
						color:".$params->get("general_elementcolor").";
					}
					.insuranceform  input::-webkit-input-placeholder
                    {
	                   color:".$params->get("placeholder_color").";
                    }
                   .insuranceform  input::-moz-input-placeholder
                   {
			           color:".$params->get("placeholder_color").";
                   }
                   .insuranceform  input::-ms-input-placeholder
                   {
	                   color:".$params->get("placeholder_color").";
                   }
					.insuranceform textarea
					{
						background-color:".$params->get("input_backcolor").";
						border:".$params->get("input_border")."px;
						border-color:".$params->get("input_bordercolor").";
						resize:vertical;
					}
					
					.insuranceform  label
					{
						color:".$params->get("label_color").";
						background-color:".$params->get("label_backcolor").";
						border:".$params->get("label_border")."px;
						border-color:".$params->get("label_bordercolor").";
						text-align:".$params->get("label_textalign").";
						width:".$params->get("label_width")."%;
						font-size:".$params->get("form_fontsize")."px;
						font-weight:".$params->get("form_fontweight").";


					}
					.insuranceform  input[type='button'],
					.insuranceform  input[type='reset']
					{
						color:".$params->get("button_color").";
						background-image:none;
						background-color:".$params->get("button_backcolor").";
					}
					.insuranceform  input[type='file']
					{
						color:".$params->get("inputfile_color").";
						display:".$params->get("inputfile_display").";
					}

					.insuranceform  div.buttonholder
					{
						width:".$params->get("buttonholder_width")."px;
						overflow:auto;
						float:".$params->get("buttonsholder_align").";
					}
					.insuranceform div.tab
					{
						box-sizing:border-box;
	                    -moz-box-sizing:border-box;
	                    -webkit-box-sizing:border-box;
						display:none;
						margin-left:".$params->get("tab_marginleft")."px;
						margin-right:".$params->get("tab_marginright")."px;
						float:".$params->get("tab_align").";
						height:auto;
						width:".$params->get("tab_width")."%;						
					}
					.insuranceform div.tab .myprogress
					{
						width:".$params->get("progressbar_width")."%;
						margin-top:5px;
						
						
					}
					.insuranceform div.tab .myprogress div.bar
                    {
					  background-color:".$params->get("progressbar_backcolor").";
					  box-sizing:border-box;
                      -moz-box-sizing:border-box;
	                  -webkit-box-sizing:border-box;
					  height:inherit;
					}

					
				 ";

                 $document->addStyleDeclaration($formstyle);
				 $barmargin="";			
				 $formelements = $params->get('form_elements');
				 
				 $formelementsarray = explode(",", $formelements);

				    $tabnums = explode("tab", $formelements);
				 
			
				$formbody="";
				
				$radio="";
				$select="";
				$checked="";
				$required="";
				$star="";
				
				$k=1;
				
				$j=0;
				 for($i=0; $i<count($formelementsarray);)
				 {

					if(strstr($formelementsarray[$i], "tab"))
					{	
							

							   $formbody .= "<div class='tab'>";
							 
							   if(intval($params->get('form_progressbar'))){
								  $tn = count($tabnums);
							   $progresswidth =intval( ($k++) * (100/($tn-1)));

							  
							   $formbody .= "<div class='progress progress-striped active myprogress'><div class='bar' role='progressbar' aria-valuenow='".$progresswidth."' aria-valuemin='0' aria-valuemax='100' style='text-align:center;width:".$progresswidth."%;'><span style='color:".$params->get("progressbar_textcolor").";padding-left:3px;'>".$progresswidth."% Complete</span></div></div>";
							   }
							
									$i++;
							        $j=$i;
								

							   while(strpos($formelementsarray[$j], "tab")==false)
							   {
								  
								 
								   	$formelementarray = explode(":", $formelementsarray[$j]);
									
									 if(trim($formelementarray[0])==="div")
									 {
										 $formbody.="<div class='vh' style='height:".$formelementarray[1]."px'></div>";
									 }
									else
                                  if(trim($formelementarray[0])==="formtitle")
								   {
                                      echo "<div class='test' style='text-align:center;font-size:".$formelementarray[2]."px'>".$formelementarray[1]."</div><div style='text-align:center;font-size:".$formelementarray[2]."px'>".$formelementarray[3]."</div>";
									  if($params->get('form_logo')!==null)
									      echo "<div style='text-align:center;'><img src='".JURI::Base().$params->get('form_logo')."'  width='".$params->get('form_logo_width')."px' height='".$params->get('form_logo_height')."px' /></div>";
								   }
								   else								   
								   if(trim($formelementarray[0])==="radio")
								   {
									  
										
									 $lasts = explode("@", $formelementarray[6]);
									 if(count($lasts)==2)
									 {
										  if($lasts[0]=='checked') 
											$checked = ' checked '; 
										else
											$checked='';
									 }
									 else
									 {
										
									  if(trim($lasts[0])=='true')
									  {
										  
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}
									 }
										
									        
										
									   
									   if($formelementarray[2]!="-")
									   {
										  if($formelementarray[2]=="horizontal")
										  {  
													$flag = "horizontal";
													
										            $radio .="<label style='float:left;width:".$lasts[1]."%' class='radio-inline'><input type='".trim($formelementarray[0])."' name='jform[".$formelementarray[1]."]'  value='".$formelementarray[5]."'  ".$checked."   ".$required." />".$formelementarray[5]."</label>";
										  }
											else
											{
												$flag="";
										           $radio .="<div class='radio' style='width:".$lasts[1]."%'  ><label><input type='".trim($formelementarray[0])."' name='jform[".$formelementarray[1]."]'  value='".$formelementarray[5]."'  ".$checked."       ".$required." />".$formelementarray[5]."</label></div>";
											}
												
									   }
									   else
									   {
										    
										    $labels = explode('%', $formelementarray[5]);

										   if($flag=="horizontal")
							                    $radio .="<label style='float:left;width:".$lasts[3]."%' class='radio-inline'><input type='".trim($formelementarray[0])."' name='jform[".$formelementarray[1]."]' value='".$formelementarray[5]."' ".$checked."   ".$required." />".$labels[1]."</label>";
  										   else
										        $radio .="<div class='radio' style='width:".$lasts[3]."%'><label><input type='".trim($formelementarray[0])."' name='jform[".$formelementarray[1]."]' value='".$formelementarray[5]."' ".$checked."    ".$required." />".$labels[1]."</label></div>";

										        $radio = "<div class='clearbreak' style='margin-left:".$lasts[1]."px;margin-top:".$lasts[2]."px;'><p>".$star."".$labels[0]."</p>" .$radio."</div>";
										   
										   $formbody .=$radio;
										   $radio="";
										   $flag="";
									   }
								   }
								   else
									if(trim($formelementarray[0])==="email")
								    {
										$lasts = explode("@", $formelementarray[6]);
									  if(trim($lasts[0])=='true')
									  {
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}
										$email ="<div class='form-group' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."' placeholder='".$formelementarray[2]."' autocomplete='adieux' style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;'  ".$required." /></div>";
									    $formbody .=$email;
								    }
									else
									 if(trim($formelementarray[0])==="password")
								     {
										 $lasts = explode("@", $formelementarray[6]);
									  if(trim($lasts[0])=='true')
									  {
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}
										  
										$passw ="<div class='form-group' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;'  ".$required."  /></div>";
									    $formbody .=$passw;
								}
								else
								 if(trim($formelementarray[0])==="date")
								 {
										  $lasts = explode("@", $formelementarray[6]);
									  if(trim($lasts[0])=='true')
									  {
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}
										 
										
										 if(strpos($formelementarray[5], "Before")||strpos($formelementarray[5], "After")||strpos($formelementarray[5], "BA"))
										 {
											$els = explode(" ", $formelementarray[5]);
											 switch($els[0])
											 {
												 case "(Before)":
												 $fea = substr($formelementarray[5], 9);
												 break;
												 case "(After)":
												 $fea = substr($formelementarray[5], 8);
												 break;
												 case "(BA)":
												 $fea = substr($formelementarray[5], 5);
												 break;
											 }
										 }
										 if(strpos($formelementarray[5], "BA"))
										 {
											 $maxmin = explode('%', $formelementarray[2]);
										 }
										
										
										  if(strpos($formelementarray[5], "Before"))
										  {
										      $date ="<div class='form-group clearbreak' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$fea."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;' min='".$formelementarray[2]."'  ".$required." /></div>";
										  }
										  else
										  if(strpos($formelementarray[5], "After"))
										  {
											  $date ="<div class='form-group clearbreak' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$fea."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;' max='".$formelementarray[2]."'   ".$required." /></div>";
										  }
										  else
										  if(strpos($formelementarray[5], "BA"))
										  {
											  $date ="<div class='form-group clearbreak' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$fea."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;' max='".$maxmin[1]."' min='".$maxmin[0]."' ".$required." /></div>";
										  }
                                           else
										   {
											   	$date ="<div class='form-group clearbreak' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;' ".$required." /></div>";
										   }
									      $formbody .=$date;
								 }
								 else
								 if(trim($formelementarray[0])==="number")
								 {
										   $lasts = explode("@", $formelementarray[6]);
									  if(trim($lasts[0])=='true')
									  {
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}
										   
										     $minmaxstepval = explode("#", $formelementarray[2]);

										     $number ="<div class='form-group' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;'  min='".$minmaxstepval[0]."' max='".$minmaxstepval[1]."' step='".$minmaxstepval[2]."'  value='".$minmaxstepval[3]."'  ".$required." /></div>";
										  
									         $formbody .=$number;
								  }
								  else
								 if(trim($formelementarray[0])==="url")
								  {
											$lasts = explode("@", $formelementarray[6]);
									  if(trim($lasts[0])=='true')
									  {
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}
											$url ="<div class='form-group' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label><input autocomplete='adieux' type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;'  ".$required." /></div>";
									        $formbody .=$url;
								      }
									  else
									  if(trim($formelementarray[0])==="select")
								      {
											 $lasts = explode("@", $formelementarray[6]);
									  if(trim($lasts[0])=='true')
									  {
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}
										if(strpos($formelementarray[2], "multiple"))
											$multiple = " multiple ";
										else
											$multiple="";
										
											 $optionsselectmultiple = explode("#", $formelementarray[2]);
											 $select="<div class='form-group' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label>";
											 $select = $select . "<select id='".$formelementarray[1]."' name='jform[".$formelementarray[1]."][]' class='form-control'   style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;'   ".$required."   ".$multiple." >";
											    
												for($g=0; $g<count($optionsselectmultiple); $g++)
												{
													$opval = explode("%", $optionsselectmultiple[$g]);
													if($opval[0]!="type")
													{
														if(strpos($optionsselectmultiple[$g], 'selected'))
														   $select = $select . "<option value='".$opval[1]."' selected >".$opval[0]."</option>";
													    else
														   $select = $select . "<option value='".$opval[1]."'  >".$opval[0]."</option>";
													}

												}
												$select .= "</select></div>";
											 $formbody.=$select;
								}
								 else
								if(trim($formelementarray[0])==="text")
								{
											$lasts = explode("@", $formelementarray[6]);
									  if(trim($lasts[0])=='true')
									  {
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}  
											  $text ="<div class='form-group ' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label  style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."' placeholder='".$formelementarray[2]."' autocomplete='adieux' style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;'  ".$required." /></div>";
									          $formbody .=$text;
								    }
									else
									if(trim($formelementarray[0])==="textarea")
								    {
											   
											   $lasts = explode("@", $formelementarray[6]);
									  if(trim($lasts[0])=='true')
									  {
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}
											  $textarea ="<div class='form-group' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."(do not type comma in textarea)</label><textarea  autocomplete='adieux' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;' ".$required." ></textarea></div>";
									          $formbody .=$textarea;
								           }
									       else
									        if(trim($formelementarray[0])==="checkbox")
								            {
												$reqchek = explode('@', $formelementarray[6]);
												 if(trim($reqchek[0])=='true')
									             {
											          $required = 'required';
											          $star='*';
									             }
									             else
										         {
											        $required='';
											           $star='';
										         }
												 
												  if(trim($reqchek[1])=='true')
									             {
													 $checked = 'checked';
													 $cvalue = 'true';
												 }
												 else
												 {
													 $checked = '';
													 $cvalue = 'false';
												 }
												
										  if($formelementarray[3]!="1")
                                          {
											if($formelementarray[2]=="horizontal")
											{
												
										        $checkbox .="<label style='float:left;width:".$reqchek[4]."px' class='checkbox-inline' for='".$formelementarray[1]."'>".$star."<input type='hidden' name='jform[".$formelementarray[1]."]'   value='false'  /> <input type='".trim($formelementarray[0])."' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."' value='".$cvalue."'  ".$required."  ".$checked." />  ".$formelementarray[5]."</label>";
											}
											 else
									             $checkbox .="<div class='checkbox'><label style='width:".$reqchek[4]."px' for='".$formelementarray[1]."'>".$star."<input type='hidden' name='jform[".$formelementarray[1]."]'   value='false'  /><input class='checkbox' type='".trim($formelementarray[0])."' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  value='".$cvalue."' ".$required."  ".$checked." />  ".$formelementarray[5]."</label></div>";
										  }
											else
										    {
												
												
												if($formelementarray[2]=="horizontal")
											    {												
                                                  $checkbox .="<label style='float:left;width:".$reqchek[4]."px' class='checkbox-inline' for='".$formelementarray[1]."'>".$star."<input type='hidden' name='jform[".$formelementarray[1]."]'   value='false'  /><input type='".trim($formelementarray[0])."' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."' value='".$cvalue."'  ".$required."  ".$checked." />  ".$formelementarray[5]."</label>";

												}
											    else
											      $checkbox .="<div class='checkbox'><label style='width:".$reqchek[4]."px' for='".$formelementarray[1]."'>".$star."<input type='hidden' name='jform[".$formelementarray[1]."]'   value='false'  /><input class='checkbox' type='".trim($formelementarray[0])."' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  value='".$cvalue."'  ".$required."   ".$checked."  /> ".$formelementarray[5]."</label></div>";
											     $formbody .="<div class='clearbreak' style='margin-left:".$reqchek[2]."px;margin-top:".$reqchek[3]."px;'><p>".$formelementarray[4]."</p>".$checkbox."</div>";											 
											     $checkbox="";
										      }
								            }
											 else
									        if(trim($formelementarray[0])==="range")
								            {
												$lasts = explode("@", $formelementarray[6]);
									            if(trim($lasts[0])=='true')
									            {
											     $required = 'required';
											     $star='*';
									            }
									            else
										       {
											    $required='';
											    $star='';
										       }
												$minmax = explode("#", $formelementarray[2]);
										        $range ="<div class='form-group' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;'  min='".$minmaxstepval[0]."' max='".$minmaxstepval[1]."'   ".$required." /></div>";
										        $formbody .=$range;
								            }
											else
											if(trim($formelementarray[0])==="file" )
								            {
											$lasts = explode("@", $formelementarray[6]);
									          if(trim($lasts[0])=='true')
									          {
											    $required = 'required';
											    $star='*';
									          }
									          else
										     {
											   $required='';
											   $star='';
										     }
											if(strpos($formelementarray[2], "%") )
											{
											  $placeaccept = explode("%",$formelementarray[2]);
											  if(strpos($placeaccept[1], '|'))
											      $extensions = str_replace('|', ',', $placeaccept[1]);
											  else
												  $extensions = $placeaccept[1];
											  
											  $placeholder = $placeaccept[0];
											}
											else
											{
												$extensions = "";
												$placeholder = $formelementarray[2];
											}
											
											  $file ="<div class='form-group' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."' placeholder='".$placeholder."' accept='".$extensions."' style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;'  ".$required." /></div>";
											 
											 
											  $formbody .=$file;
								          }
								   
								   $j++;
								   $i = $j;

								    if($j==count($formelementsarray))
									{
										
										if($params->get('recaptcha')=='true')
                                          $formbody .="Security:<br /><div class='g-recaptcha' id='rcaptcha'  data-sitekey='".$params->get('recaptcha_key')."'></div><span id='captcha' style='color:red' /></span><p></p>";
										  break;
									}
								
									 
							   }
							   $formbody .="</div>";

                    }
					else
					{	
						
						$formelementarray = explode(":", $formelementsarray[$i]);
									
									 if(trim($formelementarray[0])==="div")
									 {
										 $formbody.="<div class='vh' style='height:".$formelementarray[1]."px'></div>";
									 }
									else
                                  if(trim($formelementarray[0])==="formtitle")
								   {
                                      echo "<div class='test' style='text-align:center;font-size:".$formelementarray[2]."px'>".$formelementarray[1]."</div><div style='text-align:center;font-size:".$formelementarray[2]."px'>".$formelementarray[3]."</div>";
									  if($params->get('form_logo')!==null)
									      echo "<div style='text-align:center;'><img src='".JURI::Base().$params->get('form_logo')."'  width='".$params->get('form_logo_width')."px' height='".$params->get('form_logo_height')."px' /></div>";
								   }
								   else								   
								   if(trim($formelementarray[0])==="radio")
								   {
									  
										
									 $lasts = explode("@", $formelementarray[6]);
									 if(count($lasts)==2)
									 {
										  if($lasts[0]=='checked') 
											$checked = ' checked '; 
										else
											$checked='';
									 }
									 else
									 {
									  if(trim($lasts[0])=='true')
									  {
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}
									 }
										
									        
										
									   
									   if($formelementarray[2]!="-")
									   {
										  if($formelementarray[2]=="horizontal")
										  {  
													$flag = "horizontal";
													
										            $radio .="<label style='float:left;width:".$lasts[1]."%' class='radio-inline'><input type='".trim($formelementarray[0])."' name='jform[".$formelementarray[1]."]'  value='".$formelementarray[5]."'  ".$checked."   ".$required." />".$formelementarray[5]."</label>";
										  }
											else
											{
												$flag="";
										           $radio .="<div class='radio' style='width:".$lasts[1]."%'  ><label><input type='".trim($formelementarray[0])."' name='jform[".$formelementarray[1]."]'  value='".$formelementarray[5]."'  ".$checked."       ".$required." />".$formelementarray[5]."</label></div>";
											}
												
									   }
									   else
									   {
										    
										    $labels = explode('%', $formelementarray[5]);

										   if($flag=="horizontal")
							                    $radio .="<label style='float:left;width:".$lasts[3]."%' class='radio-inline'><input type='".trim($formelementarray[0])."' name='jform[".$formelementarray[1]."]' value='".$formelementarray[5]."' ".$checked."   ".$required." />".$labels[1]."</label>";
  										   else
										        $radio .="<div class='radio' style='width:".$lasts[3]."%'><label><input type='".trim($formelementarray[0])."' name='jform[".$formelementarray[1]."]' value='".$formelementarray[5]."' ".$checked."    ".$required." />".$labels[1]."</label></div>";

										        $radio = "<div class='clearbreak' style='margin-left:".$lasts[1]."px;margin-top:".$lasts[2]."px;'><p>".$star."".$labels[0]."</p>" .$radio."</div>";
										   
										   $formbody .=$radio;
										   $radio="";
										   $flag="";
									   }
								   }
								   else
									if(trim($formelementarray[0])==="email")
								    {
										$lasts = explode("@", $formelementarray[6]);
									  if(trim($lasts[0])=='true')
									  {
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}
										$email ="<div class='form-group' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."' placeholder='".$formelementarray[2]."' autocomplete='adieux' style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;'  ".$required." /></div>";
									    $formbody .=$email;
								    }
									else
									 if(trim($formelementarray[0])==="password")
								     {
										 $lasts = explode("@", $formelementarray[6]);
									  if(trim($lasts[0])=='true')
									  {
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}
										  
										$passw ="<div class='form-group' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;'  ".$required."  /></div>";
									    $formbody .=$passw;
								}
								else
								 if(trim($formelementarray[0])==="date")
								 {
										  $lasts = explode("@", $formelementarray[6]);
									  if(trim($lasts[0])=='true')
									  {
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}
										 
										
										 if(strpos($formelementarray[5], "Before")||strpos($formelementarray[5], "After")||strpos($formelementarray[5], "BA"))
										 {
											$els = explode(" ", $formelementarray[5]);
											 switch($els[0])
											 {
												 case "(Before)":
												 $fea = substr($formelementarray[5], 9);
												 break;
												 case "(After)":
												 $fea = substr($formelementarray[5], 8);
												 break;
												 case "(BA)":
												 $fea = substr($formelementarray[5], 5);
												 break;
											 }
										 }
										 if(strpos($formelementarray[5], "BA"))
										 {
											 $maxmin = explode('%', $formelementarray[2]);
										 }
										
										
										  if(strpos($formelementarray[5], "Before"))
										  {
										      $date ="<div class='form-group clearbreak' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$fea."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;' min='".$formelementarray[2]."'  ".$required." /></div>";
										  }
										  else
										  if(strpos($formelementarray[5], "After"))
										  {
											  $date ="<div class='form-group clearbreak' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$fea."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;' max='".$formelementarray[2]."'   ".$required." /></div>";
										  }
										  else
										  if(strpos($formelementarray[5], "BA"))
										  {
											  $date ="<div class='form-group clearbreak' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$fea."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;' max='".$maxmin[1]."' min='".$maxmin[0]."' ".$required." /></div>";
										  }
                                           else
										   {
											   	$date ="<div class='form-group clearbreak' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;' ".$required." /></div>";
										   }
									      $formbody .=$date;
								 }
								 else
								 if(trim($formelementarray[0])==="number")
								 {
										   $lasts = explode("@", $formelementarray[6]);
									  if(trim($lasts[0])=='true')
									  {
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}
										   
										     $minmaxstepval = explode("#", $formelementarray[2]);

										     $number ="<div class='form-group' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;'  min='".$minmaxstepval[0]."' max='".$minmaxstepval[1]."' step='".$minmaxstepval[2]."'  value='".$minmaxstepval[3]."'  ".$required." /></div>";
										  
									         $formbody .=$number;
								  }
								  else
								 if(trim($formelementarray[0])==="url")
								  {
											$lasts = explode("@", $formelementarray[6]);
									  if(trim($lasts[0])=='true')
									  {
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}
											$url ="<div class='form-group' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label><input autocomplete='adieux' type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;'  ".$required." /></div>";
									        $formbody .=$url;
								      }
									  else
									  if(trim($formelementarray[0])==="select")
								      {
											 $lasts = explode("@", $formelementarray[6]);
									  if(trim($lasts[0])=='true')
									  {
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}
										if(strpos($formelementarray[2], "multiple"))
											$multiple = " multiple ";
										else
											$multiple="";
										
											 $optionsselectmultiple = explode("#", $formelementarray[2]);
											 $select="<div class='form-group' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label>";
											 $select = $select . "<select id='".$formelementarray[1]."' name='jform[".$formelementarray[1]."][]' class='form-control'   style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;'   ".$required."   ".$multiple." >";
											    
												for($g=0; $g<count($optionsselectmultiple); $g++)
												{
													$opval = explode("%", $optionsselectmultiple[$g]);
													if($opval[0]!="type")
													{
														if(strpos($optionsselectmultiple[$g], 'selected'))
														   $select = $select . "<option value='".$opval[1]."' selected >".$opval[0]."</option>";
													    else
														   $select = $select . "<option value='".$opval[1]."'  >".$opval[0]."</option>";
													}

												}
												$select .= "</select></div>";
											 $formbody.=$select;
								}
								 else
								if(trim($formelementarray[0])==="text")
								{
											$lasts = explode("@", $formelementarray[6]);
									  if(trim($lasts[0])=='true')
									  {
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}  
											  $text ="<div class='form-group ' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label  style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."' placeholder='".$formelementarray[2]."' autocomplete='adieux' style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;'  ".$required." /></div>";
									          $formbody .=$text;
								    }
									else
									if(trim($formelementarray[0])==="textarea")
								    {
											   
											   $lasts = explode("@", $formelementarray[6]);
									  if(trim($lasts[0])=='true')
									  {
											$required = 'required';
											$star='*';
									  }
									    else
										{
											$required='';
											$star='';
										}
											  $textarea ="<div class='form-group' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."(do not type comma in textarea)</label><textarea  autocomplete='adieux' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;' ".$required." ></textarea></div>";
									          $formbody .=$textarea;
								           }
									       else
									        if(trim($formelementarray[0])==="checkbox")
								            {
												$reqchek = explode('@', $formelementarray[6]);
												 if(trim($reqchek[0])=='true')
									             {
											          $required = 'required';
											          $star='*';
									             }
									             else
										         {
											        $required='';
											           $star='';
										         }
												 
												  if(trim($reqchek[1])=='true')
									             {
													 $checked = 'checked';
													 $cvalue = 'true';
												 }
												 else
												 {
													 $checked = '';
													 $cvalue = 'false';
												 }
												
										  if($formelementarray[3]!="1")
                                          {
											if($formelementarray[2]=="horizontal")
											{
												
										        $checkbox .="<label style='float:left;width:".$reqchek[4]."px' class='checkbox-inline' for='".$formelementarray[1]."'>".$star."<input type='hidden' name='jform[".$formelementarray[1]."]'   value='false'  /> <input type='".trim($formelementarray[0])."' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."' value='".$cvalue."'  ".$required."  ".$checked." />  ".$formelementarray[5]."</label>";
											}
											 else
									             $checkbox .="<div class='checkbox'><label style='width:".$reqchek[4]."px' for='".$formelementarray[1]."'>".$star."<input type='hidden' name='jform[".$formelementarray[1]."]'   value='false'  /><input class='checkbox' type='".trim($formelementarray[0])."' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  value='".$cvalue."' ".$required."  ".$checked." />  ".$formelementarray[5]."</label></div>";
										  }
											else
										    {
												
												
												if($formelementarray[2]=="horizontal")
											    {												
                                                  $checkbox .="<label style='float:left;width:".$reqchek[4]."px' class='checkbox-inline' for='".$formelementarray[1]."'>".$star."<input type='hidden' name='jform[".$formelementarray[1]."]'   value='false'  /><input type='".trim($formelementarray[0])."' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."' value='".$cvalue."'  ".$required."  ".$checked." />  ".$formelementarray[5]."</label>";

												}
											    else
											      $checkbox .="<div class='checkbox'><label style='width:".$reqchek[4]."px' for='".$formelementarray[1]."'>".$star."<input type='hidden' name='jform[".$formelementarray[1]."]'   value='false'  /><input class='checkbox' type='".trim($formelementarray[0])."' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  value='".$cvalue."'  ".$required."   ".$checked."  /> ".$formelementarray[5]."</label></div>";
											     $formbody .="<div class='clearbreak' style='margin-left:".$reqchek[2]."px;margin-top:".$reqchek[3]."px;'><p>".$formelementarray[4]."</p>".$checkbox."</div>";											 
											     $checkbox="";
										      }
								            }
											 else
									        if(trim($formelementarray[0])==="range")
								            {
												$lasts = explode("@", $formelementarray[6]);
									            if(trim($lasts[0])=='true')
									            {
											     $required = 'required';
											     $star='*';
									            }
									            else
										       {
											    $required='';
											    $star='';
										       }
												$minmax = explode("#", $formelementarray[2]);
										        $range ="<div class='form-group' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."'  style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;'  min='".$minmaxstepval[0]."' max='".$minmaxstepval[1]."'   ".$required." /></div>";
										        $formbody .=$range;
								            }
											else
											if(trim($formelementarray[0])==="file" )
								            {
											$lasts = explode("@", $formelementarray[6]);
									          if(trim($lasts[0])=='true')
									          {
											    $required = 'required';
											    $star='*';
									          }
									          else
										     {
											   $required='';
											   $star='';
										     }
											if(strpos($formelementarray[2], "%") )
											{
											  $placeaccept = explode("%",$formelementarray[2]);
											  if(strpos($placeaccept[1], '|'))
											      $extensions = str_replace('|', ',', $placeaccept[1]);
											  else
												  $extensions = $placeaccept[1];
											  
											  $placeholder = $placeaccept[0];
											}
											else
											{
												$extensions = "";
												$placeholder = $formelementarray[2];
											}
											
											  $file ="<div class='form-group' style='display:".$lasts[1].";margin-left:".$lasts[2]."px;margin-top:".$lasts[3]."px;'><label style='width:".$lasts[4]."%' for='".$formelementarray[1]."'>".$star."".$formelementarray[5]."</label><input type='".trim($formelementarray[0])."' class='form-control' name='jform[".$formelementarray[1]."]'  id='".$formelementarray[1]."' placeholder='".$placeholder."' accept='".$extensions."' style='margin-left:".$lasts[5]."px;margin-top:".$lasts[6]."px;width:".$formelementarray[3]."px;height:".$formelementarray[4]."px;'  ".$required." /></div>";
											 
											 
											  $formbody .=$file;
								          }
								   
								   
								   $i++;

								    if($i==count($formelementsarray))
									{
										if($params->get('recaptcha')=='true')
                                          $formbody .="Security:<br /><div class='g-recaptcha' id='rcaptcha'  data-sitekey='".$params->get('recaptcha_key')."'></div><span id='captcha' style='color:red' /></span><p></p>";
										  break;
									}
									
							

								
					}		 
							   
							
					
					
					
				 }
				 echo $formbody;
				  
			if(count($tabnums)>=2)
			{		

					return 2;
			}
			else
				return true;
				
					
			}
			


		}	
		
}
