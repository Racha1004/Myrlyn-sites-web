<?php 

class Image
{
	public function recadrer_image($original_file_name,$cropped_file_name,$max_width,$max_height)
	{
		if(file_exists($original_file_name))
		{
			$original_image=imagecreatefromjpeg($original_file_name);

			$original_width=imagesx($original_image);
			$original_height=imagesy($original_image);

			if($original_height > $original_width)
			{
 
			}else
			{

			}
		}
		imagecopyresampled(dst_image,src_image,dst_x,dst_y,src_x,src_y,dst_w,dst_h,src_w,src_h);
	}
}




