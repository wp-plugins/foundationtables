<?php
/*
Plugin Name: FoundationTables
Plugin URI: http://wordpress.org/plugins/foundationtables/
Description: Easily insert and manage tabled content for the pages of your foundation theme.
Version: 0.2
Author: ERA404 Creative Group, Inc.
Author URI: http://www.era404.com
License: GPLv2 or later.
Copyright 2014  era404 Creative Group, Inc.  (email : in4m@era404.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

//globals
define('FOUNDTAB_URL', admin_url() . 'options-general.php?page=foundationtables');

// Setup plugin scripts and styles

wp_enqueue_script( 'ajax-script', plugins_url('/foundationtables.js', __FILE__), array('jquery'), 1.0 ); // jQuery will be included automatically
function foundationtables_scripts() {
	wp_enqueue_style( 'style-name', plugins_url('/foundationtables.css', __FILE__) );
}
add_action( 'wp_enqueue_scripts', 'foundationtables_scripts' );

//sizes of the columns (12 total)
$colw = array(	1=>"[1] x-small",
				2=>"[2] small",
				3=>"[3] medium",
				4=>"[4] wide",
				6=>"[6] x-wide"
);

// add simple table support to the pages
add_action("admin_init", "foundtabs");
function foundtabs(){ add_meta_box( "foundationtables", "Foundation Tables", "foundtab_build", "page"); }
function foundtab_build(){
	global $post, $colw;
	$rows = 12;	$cols = 6;
	$colwidth = floor(708/$cols);

	$foundtab = foundtab_query($post->ID);	//query db
	
	//echo "<textarea>"; print_r($foundtab); echo "</textarea>";

	echo "<style>
			table.foundtab {
				width:720px;
				border-spacing:0;
				border-collapse: separate;
				border: 1px solid #FFF;
				box-shadow: 0 0 2px #9B9B9B;
				-moz-box-shadow: 0 0 2px #9B9B9B;
				-webkit-box-shadow: 0 0 2px #9B9B9B;
				background: #ECECEC;
				font: normal normal 11px/14px Arial, Helvetical, sans-serif;
				margin: 12px 0 6px;
			}
			#foundationtables h3.hndle {
				background: #BD4825;
				color: #FFF;
			}
			#foundationtables input, select {
				background: #BD4825;
				border: 0;
				text-align: center;
				text-transform: uppercase;
				font-size: 10px;
				padding: 4px 12px;
				font-weight: bold;
				cursor: pointer;
			}
			#foundationtables thead select {
				background: #FFF;
				width: 238px;
			}
			#foundationtables tbody select {
				background: #BEBEBE;
			}
			#foundationtables input[type='button'] {
				color: #FFF;
				transition: background .25s;
				-moz-transition: background .25s;
				-webkit-transition: background .25s;
			}
			#foundationtables input[type='button']:hover {
				background: #444;
			}
			#foundationtables hr {
				margin: 15px 13px 15px 0;
			}
			table.foundtab tbody {
				
			}
			table.foundtab tr.vis0 {
				display:none;
			}
			table.foundtab td,
			table.foundtab th {
				width: {$colwidth}px;
				text-align: left;
				padding: 0;
			}
			table.foundtab th.notab {
				padding-bottom: 2px;
			}
			table.foundtab th.tab {
				text-align: right;
				padding-right: 6px;
			}
			table.foundtab textarea {
				width: ".($colwidth-1)."px;
				height: 60px;
				z-index: 0;
				margin-left: 1px;
				font-size: 10px;
			}
			table.foundtab textarea.active {
			    -webkit-transition: all 0.2s ease;
			    -moz-transition: all 0.2s ease;
			    -o-transition: all 0.2s ease;
			    transition: all 0.2s ease;
			    position:absolute;
			    width: 700px;
			    height: 200px;
			    z-index:1;
			   	border: 1px solid #B74327; 
				box-shadow: 0 0 4px rgba(0,0,0,.1);
				-moz-box-shadow: 0 0 4px rgba(0,0,0,.1);
				-webkit-box-shadow: 0 0 4px rgba(0,0,0,.1);
				font-size: 12px;
			}
			table.foundtab input,
			table.foundtab select {
				width: ".($colwidth-1)."px;
				text-align: left;
			}
			select.foundtab_stylechooser {
				width: 100px;
			}
			select.foundtab_stylechooser option {
			    font-size: 10px;
				height: 38px;
				text-align: left;
			}
			select.foundtab_stylechooser option:hover {
				color: #B74327 !important;
			}
			div.donate {
				margin-top: 10px;
			}
			#foundationtables input[type='image'] {
				background: none;
			}
			#donate {
				font-size: 11px;
				line-height: 16px;
				margin: 30px 0 4px -12px;
				border-top: 1px solid #B74327;
				padding: 10px 4px 0 4px;
				width: 750px;
			}
			#donate a {
				color: #B74327;
				text-decoration: none;	
			}
			input.donate {
				margin: -1px 8px 0 -4px;
			}
			
		  </style>";
	
	echo "<p><strong>Instructions:</strong> 
				Insert this table into the page body by using the shortcode <span style='color:black'><b>[foundtab]</b></span> anywhere in the above block.<br />
				Because Foundation uses a 12-column grid, your column widths should add up to 12 or less.</p>";
	
	foreach($foundtab as $ftid=>$ftab){
		$style = (isset($ftab[-1])?$ftab[-1]:false);

		echo "<table id='foundtab[$ftid]' class='foundtab'>
				<thead>
					<tr><th colspan='5' class='notab'>".foundtab_stylechooser($ftid,$style)."</th>
						<th class='tab'>foundtab_{$ftid}</th></tr></thead>";
		//header row
		echo "<tbody><tr>";
		for($c=0; $c<$cols; $c++){
			echo "<td><select name='foundtab[$ftid][0][$c]'>";
			echo "<option value='' ".(""==trim($ftab[0][$c]) ? "selected='SELECTED'" : "")."></option>";
			foreach($colw as $s=>$w) echo "\n\t<option value='$s' ".($ftab[0][$c] == $s ? "selected='SELECTED'" : "").">$w</option>";
			echo "</select></td>";
		}
		echo "</tr>";
	
	
		//rows - hide with vis0 until needed
		for($r=1; $r<=$rows; $r++) {
			echo "<tr ".((""==trim($ftab[$r][0]) && $r>1)?"class='vis0'":"").">";
			for($c=0; $c<$cols; $c++) {
				echo "<td><textarea name='foundtab[$ftid][$r][$c]'>".br2nl($ftab[$r][$c])."</textarea></td>";
			}
			echo "</tr>";
		}
		echo "</tbody></table><input type='button' class='foundtab_addrow' value='Add Row' /> <hr />";
	}
	echo "<input type='button' class='foundtab_addtab' value='Add Table' /> <hr />";
echo <<<PAYPAL
	<div class="donate" style='display: none;'>
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="22QLVNCTBFAWQ">
	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/x-click-but04.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" align="left" class="donate">
		If <b>FoundationTables</b> has made your life easier, and you wish to say thank you, a Secure PayPal link has been provided to the left. See more <a href='http://profiles.wordpress.org/era404/' title='WordPress plugins by ERA404' target='_blank'>WordPress plugins by ERA404</a> or visit us online:
		<a href='http://www.era404.com' title='ERA404 Creative Group, Inc.' target='_blank'>www.era404.com</a>. Thanks for using FoundationTables.
	</div>
PAYPAL;
}


add_action('save_post', 'foundtab_save');
function foundtab_save(){
	global $post;							//myprint_r($_POST['foundtab']); 
	$foundtab = foundtab_query($post->ID);	//myprint_r($foundtab);
	foreach($_POST['foundtab'] as $ftid=>$ftab) { $empty = true;
		foreach($ftab as $ftrow=>$ftcols){
			if(strlen(trim(implode("",array_values($ftcols))))>0) $empty = false;
		}
		if($empty) {	//allows us to save an empty table over a stored one
			if(empty($foundtab[$ftid])) unset($_POST['foundtab'][$ftid]); //remove empty tables & keep db compact
		}
	}
	if(!empty($_POST['foundtab'])) { update_post_meta(@$post->ID, "foundtab", $_POST["foundtab"]); }
}
function br2nl($in){
	$breaks = array("<br />","<br>","<br/>");
	$out = str_ireplace($breaks, "\n", $in);
	return $out;
}

function getFoundationTable($tab) {		//myprint_r($tab);
	//count columns first
	$cct = 0;
	foreach($tab[0] as $columns)	if(trim($columns)!="") $cct++;
	
	//grab styles
	if(isset($tab[-1])){ $style = "foundtab_{$tab[-1]}"; unset($tab[-1]); }
	else { $style = ""; }
	
	//grab widths
	$w = $tab[0]; unset($tab[0]);
	
	$out = "\n<div class='row foundtab $style'><div class='large-12 columns'>";
	$widths = array(1=>"large-1",2=>"large-2",3=>"large-3",4=>"large-4",6=>"large-6");

	foreach($tab as $r=>$row){
		//skip blank
		$test = trim(implode("",$row)); if($test=="") continue;
		//each row
		$out .= "\n<div class='row'>";

		foreach($row as $c=>$column){
			//skip last column if empty
			if(($c+1)>$cct) continue;
				
			//each column
			$out .= "\n<div class='small-12 ".($widths[$w[$c]])." columns'>{$column}</div>";
		}
		$out .= "\n</div>";
	}
	$out .= "\n</div></div>";
	return $out;
}

function foundtab_insert($content) {
	global $post;															//echo "POST: {$post->ID}";
	$foundtab = foundtab_query($post->ID); 									//myprint_r($foundtab);
	preg_match_all(	'/<div[^>]*id=\"foundtab_(\d+)\"[^>]*><\/div>/i', 
					$content, $match, PREG_PATTERN_ORDER);					//myprint_r($match);
	if($match&&!empty($match[0])){ //tables found
		foreach($match[0] as $i=>$shortcode){
			$tid =$match[1][$i];
			$tablehtml = getFoundationTable($foundtab[$tid]);
			$content = str_replace($shortcode,$tablehtml,$content);
		}
	}
	
	
	// otherwise returns the database content
	return $content;
}

add_filter( 'the_content', 'foundtab_insert' );


//initiate with tinymce
add_action( 'init', 'foundtab_buttons' );
function foundtab_buttons() {
	add_filter( "mce_external_plugins", "foundtab_add_buttons" );
	add_filter( 'mce_buttons', 'foundtab_register_buttons' );
}
function foundtab_add_buttons( $plugin_array ) {
	$plugin_array['foundtab'] = plugins_url() . '/foundationtables/foundationtables_button.js';
	return $plugin_array;
}
function foundtab_register_buttons( $buttons ) {
	array_push( $buttons, 'foundtab_insert');
	return $buttons;
}
function foundtab_add_editor_styles() {
	add_editor_style( plugins_url() . '/foundationtables/foundationtables_rte.css' );
}
add_action( 'init', 'foundtab_add_editor_styles' );

/**************************************************************************************************
*	Some useful functions
**************************************************************************************************/
//development assists
if(!function_exists("myprint_r")){	function myprint_r($in) {	echo "<pre>"; print_r($in); echo "</pre>"; return; }}

function foundtab_query($id){
	$custom = get_post_custom($id);
	$foundtab = $custom['foundtab'];
	if(empty($foundtab)){ $foundtab = array(0=>array(false)); } 						// this is a clean table to start
	else { foreach($foundtab as $ftid=>$ftab) $foundtab[$ftid]=unserialize($ftab); }	//prepare stored tables
	return($foundtab[0]);
}

function foundtab_stylechooser($ftid,$style){
	$css = file(plugin_dir_path(__FILE__)."foundationtables.css"); $css = implode("",$css);
	preg_match_all("/\/\*+\sStyle::([^\d:]+)::\(([^\:].+)\)::\*+\//im",$css,$styles);
	if(count($styles)==3){
		$out = "<select name='foundtab[$ftid][-1]' class='foundtab_stylechooser'>";
		foreach($styles[1] as $si=>$sv) {
			$out .= "<option value='{$styles[1][$si]}' 
							 style='background:url(\"" . plugins_url() . "/foundationtables/styles/{$styles[1][$si]}.png\") top left no-repeat;'
							 ".($style==$styles[1][$si]?" selected='selected'":"").
							 ">{$styles[2][$si]}</option>";
		}
		$out .= "</select>";
	}
	return $out;
}

?>
