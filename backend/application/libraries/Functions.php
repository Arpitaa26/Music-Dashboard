<?php
	class Functions 
	{
		function __construct()
		{
			$this->obj =& get_instance(); 
		}

	
		// --------------------------------------------------------------
		/*
		* Function Name : File Upload
		* Param1 : Location
		* Param2 : HTML File ControlName
		* Param3 : Extension
		* Param4 : Size Limit
		* Return : FileName
		*/
	   
		function file_insert($location, $controlname, $type, $size)
		{
			$return = array();
			$type = strtolower($type);
			if(isset($_FILES[$controlname]) && $_FILES[$controlname]['name'] != NULL)
	        {
				$filename = $_FILES[$controlname]['name'];
				$file_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
				$filesize = $_FILES[$controlname]["size"];	
						
				if($type == 'image')
				{
					if($file_extension == 'jpg' || $file_extension == 'jpeg' || $file_extension == 'png' || $file_extension == 'gif')
					{
						if ($filesize <= $size) 
						{
							$new_filename= $this->file_upload($location, $controlname);
							$splitn = explode(".", $new_filename);
					        $fileext = current($splitn);
						      return [
						      	'msg'=>$new_filename,
								"file_name" =>$new_filename,
								"slug" => $fileext,
								"mime_type" =>$_FILES[$controlname]['type'],
								"path" => $location.$new_filename,
								"original_name"=>$_FILES[$controlname]['name'],
								"status" => '1'
						      ];
							//$return['msg'] = $this->file_upload($location, $controlname);
							$return['status'] = 1;
						}
						else
						{
							$size=$size/1024;
							$return['msg'] = 'File must be smaller then  '.$size.' KB';
							$return['status'] = 0;
						}
					}
					else
					{
						$return['msg'] = 'File Must Be In jpg,jpeg,png,gif Format';
						$return['status'] = 0;
						
					}
				}
				elseif($type == 'pdf')
				{
					if($file_extension == 'pdf')
					{
						if ($filesize <= $size) 
						{
							$new_filename= $this->file_upload($location, $controlname);
							$splitn = explode(".", $new_filename);
					        $fileext = current($splitn);
						      return [
						      	'msg'=>$new_filename,
								"file_name" =>$new_filename,
								"slug" => $fileext,
								"mime_type" =>$_FILES[$controlname]['type'],
								"path" => $location.$new_filename,
								"original_name"=>$_FILES[$controlname]['name'],
								"status" => '1'
						      ];
							//$return['msg'] = $this->file_upload($location, $controlname);
							$return['status'] = 1;
						}
						else
						{
							$size = $size/1024;
							$return['msg'] = 'File must be smaller then  '.$size.' KB';
							$return['status'] = 0;
						}
					}
					else
					{
						$return['msg'] = 'File Must Be In PDF Format';
						$return['status'] = 0;	
					}
				}
				elseif($type == 'excel')
				{
					if( $file_extension == 'xlsx' || $file_extension == 'xls')
					{
						if ($filesize <= $size) 
						{
							$return['msg'] = $this->file_upload($location, $controlname);
							$return['status'] = 1;
							
						}
						else
						{
							$size = $size/1024;
							$return['msg'] = 'File must be smaller then  '.$size.' KB';
							$return['status'] = 0;
						}
					}
					else
					{
						$return['msg'] = 'File Must Be In Excel Format Only allow .xlsx and .xls extension';
						$return['status'] = 0;
					}
				}
				elseif($type == 'doc')
				{
					if( $file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'txt' || $file_extension == 'rtf')
					{
						if ($filesize <= $size) 
						{
							$return['msg'] = $this->file_upload($location, $controlname);
							$return['status'] = 1;
						}
						else
						{
							$size=$size/1024;
							$return['msg'] = 'File must be smaller then  '.$size.' KB';
							$return['status'] = 0;
						}
					}
					else
					{
						$return['msg'] = 'File Must Be In doc,docx,txt,rtf Format'; 
						$return['status'] = 0;		
					}
				}
				else
				{
					$return['msg'] = 'Not Allow other than image,pdf,excel,doc file..';
					$return['status'] = 0;	
				}

			}
	        else
	        {
	            $return['msg'] = '';
				$return['status'] = 1;
	        }
			return $return;
		}


		/*
		* Function Name : File Delete
		* Param1 : Location
		* Param2 : OLD Image Name
		*/
		
		public function delete_file($oldfile)
	    {		
			if($oldfile)
			{
				if(file_exists(FCPATH.$oldfile)) 
				{
					unlink(FCPATH.$oldfile);		
				}
			}
	    }
	

		//--------------------------------------------------------
		/*
		* Function Name : File Upload
		* Param1 : Location
		* Param2 : HTML File ControlName
		* Return : FileName
		*/
		function file_upload($location, $controlname)
		{
			if ( ! file_exists(FCPATH.$location))
			{
				$create = mkdir(FCPATH.$location,0777,TRUE);
				if ( ! $create)
					return '';
			}
	        
			$new_filename= $this->rename_image($_FILES[$controlname]['name']);
			if(move_uploaded_file(realpath($_FILES[$controlname]['tmp_name']),$location.$new_filename))
			{
				// $splitn = explode(".", $new_filename);
		        // $fileext = current($splitn);
			    //   return [
				// 	"file_name" =>$new_filename,
				// 	"slug" => $fileext,
				// 	"mime_type" =>$_FILES[$controlname]['type'],
				// 	"path" => $location.$new_filename,
				// 	"original_name"=>$_FILES[$controlname]['name'],
				// 	"status" => '1'
			    //   ];
				return $new_filename;
			}
			else
			{
				return '';
			}     
		}

		/*
		* Function Name : Rename Image
		* Param1 : FileName
		* Return : FileName
		*/
		public function rename_image($img_name)
	    {
	        $randString = md5(time().$img_name);
	        $fileName =$img_name;
	        $splitName = explode(".", $fileName);
	        $fileExt = end($splitName);
	        return strtolower($randString.'.'.$fileExt);
	    }
   



	}



?>