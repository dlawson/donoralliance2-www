<?php
/*
Template Name: Survey
*/

// This file is part of the Carrington JAM Theme for WordPress
// http://carringtontheme.com
//
// Copyright (c) 2008-2010 Crowd Favorite, Ltd. All rights reserved.
// http://crowdfavorite.com
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// **********************************************************************

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
if (CFCT_DEBUG) { cfct_banner(__FILE__); }

global $post;
$page_slug = $post->post_name;

get_header();
?>

<script>
var selectedTxt = "";
var caseNumber = "";

jQuery(function($){
	$("#formSelector").change(function(){
		if( $("#formSelector option:selected").attr('value') )
		{
			var selectedTxt = $("#formSelector option:selected").text();
			var caseNumber = $("#caseNumber").attr('value');
			
			$("#surveyForm").load("/survey-form/?form="+$("#formSelector option:selected").attr('value'),function (){
				$("#surveyForm input[value='caseNumber']").attr('value',caseNumber);
			});
			
			$("#surveyForm").append("<span class='loadTxt'>Loading...</span>");
			$("#surveySelectContainer").empty();
			$("#surveySelectContainer").html("<h2>"+selectedTxt+"</h2>")
		}
	});
});
</script>
<div class="col col-ab" id="surveySelectContainer">
    <label class="gfield_label" for="caseNumber">Your case number: </label>
    <input type="text" class="medium" id="caseNumber" value="" /><br /><br />
    
    <p>Please select your area of expertise.</p><br />
    <!-- 'ccathlab' => 33,
        'cechocardiogram' => 32,
        'cnuclear' => 34,
        'cpathology' => 37,
        'cradiology' => 35,
        'icharge' => 17,
        'inurse' => 13,
        'ipastoral' => 18,
        'irespiratory' => 15,
        'iunit' => 16,
        'oanesthesia' => 21,
        'ocharge' => 31,
        'ocirculator' => 20,
        'oscrub' => 19,
        'panesthesia' => 19,
        'pcardiologist' => 22,
        'pemergency' => 28,
        'phospitalist' => 27,
        'pintensivist' => 25,
        'pneuro' => 23,
        'ppathology' => 29,
        'ppulmonologists' => 24,
        'ptrauma' => 26,
        'pradiology' => 36 
    -->
	<select id="formSelector" >
    	<option value="rn">SELECT</option>
    	<optgroup label="ICU">
    		<option value="inurse">Nurse</option>
        	<option value="irespiratory">Respiratory Therapy</option>
        	<option value="iunit">Unit Clerk</option>
        	<option value="icharge">Charge/Supervisor</option>
        	<option value="ipastoral">Pastoral Care</option>
        </optgroup>
        <optgroup label="Operation Room">
            <option value="oscrub">Scrub</option>
            <option value="ocirculator">Circulator</option>
            <option value="oanesthesia">Anesthesia</option>
            <option value="ocharge">Charge/Supervisor</option>
        </optgroup>
        <optgroup label="Consultations">
            <option value="cechocardiogram">Electrocardiogram</option>
            <option value="ccathlab">Cath Lab</option>
            <option value="cnuclear">Nuclear Medicine</option>
            <option value="cpathology">Radiology</option>
            <option value="cpathology">Pathology</option>
        </optgroup>
        <optgroup label="Physicians">
            <option value="pcardiologist">Cardiologist</option>
            <option value="pradiology">Radiology</option>
            <option value="panesthesia">Anesthesia</option>
            <option value="ppathology">Pathology</option>
            <option value="pintensivist">Intensivist</option>
            <option value="ppulmonologists">Pulmonologists</option>
            <option value="pneuro">Neuro</option>
            <option value="ptrauma">Trauma</option>
            <option value="phospitalist">Hospitalist</option>
            <option value="pemergency">Emergency Room</option>
        </optgroup>
    </select>    
</div>


<div id="surveyForm">

</div>
<?php get_footer();