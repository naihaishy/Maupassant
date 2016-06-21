<?php   
  
$pageinfo = array('full_name' => '阿树工作室网站设置', 'optionname'=>'ashu', 'child'=>false, 'filename' => basename(__FILE__));   
  
$options = array();   
               
$options[] = array( "type" => "open");   
  
$options[] = array(    
                "name"=>"阿树工作室-标题",   
                "desc"=>"这是一个设置页面示范",   
                "type" => "title");   
                   
$options[] = array(   
                "name"=>"文本框",   
                "id"=>"_ashu_text",   
                "std"=>"阿树工作室文本输入框",   
                "desc"=>"阿树工作室版权所有",   
                "size"=>"60",   
                "type"=>"text"  
            );   
  
$options[] = array(   
                "name"=>"文本域",   
                "id"=>"_ashu_textarea",   
                "std"=>"阿树工作室文本域",   
                "desc"=>"阿树工作室版权所有",   
                "size"=>"60",   
                "type"=>"textarea"  
            );   
  
$options[] = array(   
            "name" => "图片上传",   
            "desc" => "请上传一个图片或填写一个图片地址",   
            "std"=>"",   
            "id" => "_ashu_logo",   
            "type" => "upload");           
  
$options[] = array(  "name" => "单选框",   
            "desc" => "请选择",   
            "id" => "_ashu_radio",   
            "type" => "radio",   
            "buttons" => array('Yes','No'),   
            "std" => 1);   
  
$options[] = array( "name" => "复选框",   
            "desc" => "请选择",   
            "id" => "checkbox_ashu",   //id必须以checkbox_开头
            "std" => 1,  
			"buttons" => array('汽车','自行车','三轮车','公交车'), 			
            "type" => "checkbox");   
               
$options[] = array( "name" => "页面下拉框",   
            "desc" => "请选择一个页面",   
            "id" => "_ashu_page_select",   
            "type" => "dropdown",   
            "subtype" => 'page'   
            );   
  
$options[] = array( "name" => "分类下拉框",   
            "desc" => "请选择大杂烩页面",   
            "id" => "_ashu_cate_select",   
            "type" => "dropdown",   
            "subtype" => 'cat'   
            );

$options[] = array( "name" => "分类下拉框",   
            "desc" => "请选择大杂烩页面",   
            "id" => "_ashu_side_select",   
            "type" => "dropdown",   
            "subtype" => 'sidebar'   
            );   
               
$options[] = array( "name" => "下拉框",   
            "desc" => "请选择",   
            "id" => "_ashu_select",   
            "type" => "dropdown",   
            "subtype" => array(   
                '苹果'=>'apple',   
                '香蕉'=>'banana',   
                '桔子'=>'orange'   
                )   
            );
			
$options[] = array(   
            "name" => "编辑器",   
            "desc" => "",   
            "id" => "tinymce_ashu",   //id必须以 tinymce_开头
            "std" => "",
            "type" => "tinymce"  
            ); 
$options[] = array(   
            "name" => "数组信息",   
            "desc" => "请输入一组id，以英文分号隔开，例如 1,2,3",   
            "id" => "numbers_ashu", //id必须以 numbers_开头
			"size"=>60,
            "std" => "",
            "type" => "numbers_array"  
            ); 			
               
$options[] = array( "type" => "close");   
  
$options_page = new ashu_option_class($options, $pageinfo);   
?>