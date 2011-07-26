<?php
$addon_name = "Collage";
$addon_description = "Creates automatic random collage of your photos.";
$addon_version = "0.3";
if (file_exists('addons/collage/Image_Toolbox.class.php') & isset($_GET['x'])& ( ($_GET['x']=='collage')/*OR($_GET['x']=='browse') */) )
{
 include('addons/collage/Image_Toolbox.class.php');

	$tz = $cfgrow['timezone'];	
	$collagecdate = gmdate("Y-m-d H:i:s",time()+(3600 * $tz)); // current date+time
	//$cdate = $datetime;				// for future posting, current date+time

	// Set Parameters
		$w =600; // Width of the whole Collage thing
		$h = 500; // Height of the whole Collage thing
		$num_image = 6;		// Number of images in the Collage
		$radius = 220;//$temp_w/3; // Radius of Spiral
  	//$bkgroundcolor = '#EBE4BD'; // Bacground color of the Collage
  	$bkgroundcolor = '#000000'; // Bacground color of the Collage
  	//$bkgroundcolor = '#ffffff'; // Bacground color of the Collage
  	$thetac = 1; // Theta accumulation		
		$each_img_w = $cfgrow['thumbwidth']; // Width of each image in the collage  ( should be less than $w)
		$each_img_h = $cfgrow['thumbheight']; // Height of each image in the collage ( should be less than $h)
		$offset = 18; // distance offset. The bigger the off set the more seperated the images
		$bpercent = 100; // alpha channel percent (how visible the overlaying of layers of collage will be)
		$border['w']= 10; // border width 
		$border['h']= 12; // border height 
		$bgc_img = '#cfcfcf';  // border color of each image
		// shading of to right below of each image
		$shade_color = '#000000';
		$shade_w= 3;
		$shade_h= 3;
		$shade_alpha = 55;
		$shadow_dist= 10;
  	
  	
  // build browse drop menu
	$browse_select = "<select name='browse' onchange='self.location.href=this.options[this.selectedIndex].value;'><option value=''>$lang_browse_select_category</option><option value='index.php?x=collage'>$lang_browse_all</option>";
	$query = mysql_query("SELECT * FROM ".$pixelpost_db_prefix."categories ORDER BY name");

	while(list($id,$name) = mysql_fetch_row($query))
	{
		$name = pullout($name);
	//		$browse_select .= "<option value='?x=browse&amp;category=$id'>$name</option>";
		$browse_select .= "<option value='index.php?x=collage&amp;category=$id'>$name</option>";
	}
	$browse_select .= "</select>";
	$tpl = ereg_replace("<COLLAGE_CATEGORIES>",$browse_select,$tpl);
	// end of building browse menu


	//show_collage_fromforlder($bkgroundcolor,$num_image,$w,$h);

	$where ='';
	$limit = " limit 0 , $num_image ";
	// build thumbnail query
	if($_GET['category'] != "") { $where = "and (t2.cat_id ='".$_GET['category']."')"; 
		// no archive date
		$query = "select t1.id,t1.headline,t1.image FROM
		{$pixelpost_db_prefix}pixelpost as t1, {$pixelpost_db_prefix}catassoc as t2
		where (t1.datetime<='$collagecdate')
		$where
		and t1.id = t2.image_id
		group by t1.id
		order by rand() " .$limit;		
	}else{

		// get images
		
		$query = "select id,headline,image from ".$pixelpost_db_prefix."pixelpost where (datetime<='$collagecdate' ) $where order by rand() " .$limit;
	}
	
	$query = mysql_query($query);
	
	//---------------------------- Making thumbs row
	$cnt = 0;
	// for each record ...
	while(list($id,$title,$name) = mysql_fetch_row($query)) {


		$clg_imgs[$cnt]['filename']= $name;
		$clg_imgs[$cnt]['title']= pullout($title);
		$clg_imgs[$cnt]['id']= $id;
		$cnt++;
	} //end while


	$collage_code = show_collage($bkgroundcolor,$num_image,$w,$h,$clg_imgs,$radius);
	
	$tpl = str_replace("<COLLAGE>",$collage_code,$tpl); // Name of the category or Month you select
	

}

/*================================= */
function show_collage($bkgroundcolor,$num_image,$w,$h,$files,$radius)
{

	global $thetac ;	
	global $each_img_w ;
	global $each_img_h ;
	global $offset;
	global $bpercent ;
	global $border;
	global $shade_color;
	global $shade_w;
	global $shade_h;
	global $shade_alpha;
	global $shadow_dist;
	
	$c_fname= '../thumbnails/thumb_20050813210411_keeptalking.jpg';
	$prefix = 'thumb_';
	$dir = 'thumbnails';
	//$dir = 'images';
	$counter = 0;

	
	// shuffle the files
	shuffle($files);
	

	$temp_w = $w-$each_img_w;
	$temp_h = $h-$each_img_h;
	//$radius = 410;//$temp_w/3;
	$ratio = $temp_w/$temp_h;
	//$circles = 4;
	$xy_pos = spiral($temp_w/2,$temp_h/2,$thetac,$radius,$num_image,$ratio,$offset);
	$xy_pos[0]['max_x'] = round($xy_pos[0]['max_x']);
	$xy_pos[0]['max_y'] = round($xy_pos[0]['max_y']);
	
	$collage = &New Image_Toolbox($w,$h,$bkgroundcolor);

	$html_code .=	'
	<script language="JavaScript">
	function highlight(detail)
{
if (document.images)
   {
   document.images[0].src=eval("d"+detail+".src");
   parent.frames[2].document.images[2].src=eval("i"+detail+".src");
   }
}</script>
	<map class="collage-image"  name="collagemap">';
			
	for ($k=0;k<$num_image&$k<count($files);$k++)	{
		$c_fname = $dir.'/'.$prefix.$files[$k]['filename'];

		if (file_exists($c_fname)){
		

		//$shade_mode = IMAGE_TOOLBOX_BLEND_COPY;
		//$shade_mode = IMAGE_TOOLBOX_BLEND_COPY;
		$shade_mode = IMAGE_TOOLBOX_BLEND_COPY;
		 
		$collage->addImage($shade_w,$each_img_h+$border['h']-$shadow_dist,$shade_color);
		
		$collage->blend($xy_pos[$k]['x']+$each_img_w+$border['w'],$xy_pos[$k]['y']+$shadow_dist,$shade_mode,$shade_alpha);
		$collage->addImage($each_img_w+$border['w']-$shadow_dist,$shade_h,$shade_color);
		$collage->blend($shadow_dist+$xy_pos[$k]['x'],$xy_pos[$k]['y']+$each_img_h+$border['h'],$shade_mode,$shade_alpha);
		
		$collage->addImage($shade_w,$shade_h,$shade_color);
		$collage->blend($xy_pos[$k]['x']+$each_img_w+$border['w'],$xy_pos[$k]['y']+$each_img_h+$border['h'],$shade_mode,$shade_alpha);
/**/
			$collage->addImage4collage($c_fname);
			//$collage->_img['operator']['resource'] = ImageRotate($collage->_img['operator']['resource'], rand(0,5)-2.5,0);
			$bmode = IMAGE_TOOLBOX_BLEND_COPY;
			//$bpercent = 75;
			
			$collage->blend($xy_pos[$k]['x'],$xy_pos[$k]['y'],$bmode,$bpercent);
				$tempstr ="<area 						
			onmouseover=\"return overlib('&lt;img src=\'thumbnails/thumb_".$files[$k]["filename"]."\' title=\'".$files[$k]["title"]."\' /&gt;', CAPTION, '".$files[$k]["title"]."', WIDTH, '$each_img_w',BGCOLOR, '#333366', FGCOLOR, '#000', RIGHT);\" onmouseout=\"return nd();\" 
   		href='index.php?showimage=".$files[$k]["id"]."' alt='".$files[$k]["title"]."' shape='rect' coords='".$xy_pos[$k]["x"].",".$xy_pos[$k]["y"].",".($xy_pos[$k]["x"]+$each_img_w).",".($xy_pos[$k]["y"]+$each_img_h)."'> ".$tempstr;
			/*
			$html_code .='<area 
			onmouseover="return overlib(\' &lt;img src=\"thumbnails/thumb_'.$files[$k]['filename'].'\" title=\"'.$files[$k]['title'].'\" /&gt;\', CAPTION, \''.$files[$k]['title'].'\', WIDTH, \''.$each_img_w.'\',BGCOLOR, \'#333366\', FGCOLOR, \'#000\', RIGHT);" onmouseout="return nd();" 
			 href="index.php?showimage='.$files[$k]['id'].'" alt="'.$files[$k]['title'].'" shape="rect" coords="'.$xy_pos[$k]['x'].','.$xy_pos[$k]['y'].','.($xy_pos[$k]['x']+$each_img_w).','.($xy_pos[$k]['y']+$each_img_h).'"> ';
			*/
		} 
	}
	
	$cdate = date("YmdHis").rand(0,9);
	delete_old_dateds('images',$cdate);
	$html_code .=	$tempstr.'</map>';
	$collage->save('images/collage_'.$cdate.'.jpg','jpg',70);
	//$html_code .= "<div style='width:".$w."px;height=".$h."px;background-color:#ffffff;' usemap='collage_map' />";
//	print_r($collage->_img);
	//$html_code .= 				$collage->_img['main']['resource'];

	//$html_code .= "<img src='".$collage->output('jpg')."' usemap='collage_map' />";
	//$html_code .= "</div>";
	$html_code .= "<img border='0px' name='collage-images' src='images/collage_".$cdate.".jpg' usemap='#collagemap' />";
	
	return $html_code;

	//printf( $html_code);
	//$collage->output('jpg');
	
}

// delete old dated files
function delete_old_dateds($dir,$cdate)
{
	if($addon_handle = opendir($dir)) {
			while (false !== ($file = readdir($addon_handle))) {
			
				if($file != "." && $file != ".." ) {
					$farry = explode('.', $file);
					reset($farry);
					$filename = $farry[0];				
					$filename_exp = explode('_', $filename);					
					$filename_crnt = $filename_exp[0];
					
					if ($filename_crnt!='collage') continue;
					
					$file_date = $filename_exp[1];
					
					$file_min = substr($file_date,0,12);
					$now_min = substr($cdate,0,12);
					
					if ( $file_min < $now_min)
					//	echo $dir.'/'.$file.' ramin is here';
						unlink($dir.'/'.$file);
					} // end if
				} // end while
			
			closedir($addon_handle);
	} // if addon_handle done    	
}
/*================================= */
function show_collage_fromforlder($bkgroundcolor,$num_image,$w,$h)
{

	
	$c_fname= '../thumbnails/thumb_20050813210411_keeptalking.jpg';
	$dir = 'thumbnails';
	$dir = '../'.$dir ;
	//echo 'alo?';
	
	$counter = 0;
	
	if($addon_handle = opendir($dir)) {
			while (false !== ($file = readdir($addon_handle))) {
				if($file != "." && $file != ".." && $file != ".DS_Store") {
					$farry = explode('.', $file);
					reset($farry);
					$filename = $farry[0];
					$filename_exp = explode('_', $filename);
					$filename_crnt = $filename_crnt[0];
					$addontype = strtolower($filename_crnt);
					$ftype = strtolower(end($farry));
					if (strtolower($ftype)=='jpg')	{									
						$files[$counter]['filename'] = $file;			
						$counter++;
					} // end if jpg
				} // end file !"."
			} // end while
		  closedir($addon_handle);
	} // if addon_handle done    
	
	// shuffle the files
	shuffle($files);
	
	$thetac = 4;

	$each_img_w = 65;
	$each_img_h = 65;
	$temp_w = $w-$each_img_w;
	$temp_h = $h-$each_img_h;
	$radius = $temp_w/3;
	$ratio = $temp_w/$temp_h;
	//$circles = 4;
	$xy_pos = spiral($temp_w/2,$temp_h/2,$thetac,$radius,$num_image,$ratio);
	$xy_pos[0]['max_x'] = round($xy_pos[0]['max_x']);
	$xy_pos[0]['max_y'] = round($xy_pos[0]['max_y']);
	
	$collage = &New Image_Toolbox($w+65,$h,$bkgroundcolor);
	/*
	if ($fixed_size)
		$collage = &New Image_Toolbox($w,$h,$bkgroundcolor);
	else
	//$collage = &New Image_Toolbox($w,$h,$bkgroundcolor);
		$collage = &New Image_Toolbox($xy_pos[0]['max_x']+1500,$xy_pos[0]['max_y']+1111,$bkgroundcolor);
	*/	
	
	$html_code .=	'<map name="collage_map">';
			
	for ($k=0;$k<$num_image&$k<count($files);$k++)	{
		$c_fname = $dir.'/'.$files[$k]['filename'];


		if (file_exists($c_fname)){

			$collage->addImage($c_fname);
			$bmode = IMAGE_TOOLBOX_BLEND_COPY;
			$bpercent = 100;
			
			$collage->blend($xy_pos[$k]['x'],$xy_pos[$k]['y'],$bmode,$bpercent);
			$html_code .='<area href="'.$c_fname.'" shape="rect" coords="'.$xy_pos[$k]['x'].','.$xy_pos[$k]['y'].',$each_img_w, $each_img_h"> ';
		}
	}
	$html_code .=	'</map>';
	$collage->save('test.jpg','jpg',70);
	$html_code .= "<img src='test.jpg' usemap='collage_map' />";
	//printf( $html_code);
	//$collage->output('jpg');
	
}

// spiral function from http://www.zend.com/tips/tips.php?id=219&single=1
function spiral( $origin_x = 100, $origin_y = 100 ,$thetac = 6 ,$radius = 15,$points,$ratio,$offset) {
 # initialize state variables
 $theta = 1;
 //$thetac = 6;  # change to tweak appearance of spiral (can be used to make other shapes)
 //$radius = 15;  # length of radius between circles (creates space between spiral circuits)
 //$circles = 10;  # number of spiral circuits to render inside image (not limited by size of image!)
 //$points = 35;  # number of points to render (the higher this number, the denser the spirals)


	$position[0]['max_x']= 0;
	$position[0]['max_y']= 0;

 # start outward spiral motion
 for( $i = 0; $i < ( $points ) ; $i++ ) {
  # create start point of spiral portion
  $theta = $theta + $thetac;
  $rad = $radius * ( ($i+$offset) / $points );
  $x = $ratio*( $rad * cos( $theta ) ) + $origin_x;
  $y = ( $rad * sin( $theta ) ) + $origin_y;

	$position[$i]['x'] = $x;
	$position[$i]['y'] = $y;
	$position[0]['max_x']= max($position[0]['max_x'],$x);
	$position[0]['max_y']= max($position[0]['max_y'],$y);

 }
 return $position;
} 
?>