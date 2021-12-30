<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('add_featured_image'))
{
	function add_featured_image()
	{
		$CI = &get_instance();

		$CI->db->order_by('created', 'DESC');
		$arr_media = $CI->db_model->get('media');

		foreach($arr_media as $k => $media)
		{
			$arr_media[$k]->path = CONTENTURL . '/' . substr($media->created, 0 ,4) . '/' . substr($media->created, 5 ,2);

			if($media->vendor == 'Youtube')
			{
				$parts = parse_url($media->url);
				parse_str($parts['query'], $query);

				$arr_media[$k]->image_thumb = 'https://img.youtube.com/vi/' . $query['v'] . '/0.jpg';
			}
		}

		$html_temp = '';

		foreach($arr_media as $media)
		{
			$ext = pathinfo($media->path . '/' . $media->name, PATHINFO_EXTENSION);
			$name = basename($media->path . '/' . $media->name, '.' . $ext);

			$html_temp .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">';
			
			if($media->vendor == 'Youtube')
			{
				$html_temp .= '<a href="#" class="add-featured-image" data-id="' . $media->id . '" data-fileurl="' . $media->image_thumb . '" data-url="' . $media->url . '"><img src="' . $media->image_thumb. '" class="img-responsive img-thumbnail media-thumbs"></a>';
			}
			else
			{
				$html_temp .= '<a href="#" class="add-featured-image" data-id="' . $media->id . '" data-fileurl="' . $media->path . '/' . $name . '-1024' . '.' . $ext . '"><img src="' . $media->path . '/' . $name . '-cropped' . '.' . $ext . '" class="img-responsive img-thumbnail media-thumbs"></a>';
			}

			$html_temp .= '</div>';
		}

		if(count($arr_media) <= 0)
		{
			$html_temp = '';
			$html_temp .= '<div style="width: 100%; text-align: center; margin-top: 20px">';
			$html_temp .= '<h5>Media is empty</h5>';
			$html_temp .= '</div>';
		}

		$auth_add_media = $CI->user_access->verify('media', 'add');

		$from_media = '';
		$from_media .= '<div class="row">';
		$from_media .= '<div class="col-md-12">';
		$from_media .= $html_temp;
		$from_media .= '</div>';
		$from_media .= '</div>';

		$upload_new = '';
		$upload_new .= '<div class="row">';
		$upload_new .= '<div class="col-md-12">';
		$upload_new .= '<form id="form_image_upload" action="' . site_url('media/ajax_add_image') . '" class="dropzone">';
		$upload_new .= '<input type="hidden" name="vendor" value="Hosted">';
		$upload_new .= '<input type="hidden" name="storage" value="Internal">';
		$upload_new .= '</form>';
		$upload_new .= '</div>';
		$upload_new .= '</div>';

		$html = '';
		$html .= '<div class="nav-tabs-custom">';
		$html .= '<ul class="nav nav-tabs">';
		$html .= '<li class="active"><a href="#from-media" data-toggle="tab">Media</a></li>';
		
		if($auth_add_media)
		{
			$html .= '<li><a id="upload_new_tab_content" href="#upload-new" data-toggle="tab">Upload New Image</a></li>';
		}

		$html .= '</ul>';

		$html .= '<div class="tab-content">';
		$html .= '<div class="tab-pane active" id="from-media">' . $from_media . '</div>';
		
		if($auth_add_media)
		{
			$html .= '<div class="tab-pane" id="upload-new">' . $upload_new . '</div>';
		}

		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}
}

if(!function_exists('add_media'))
{
	function add_media()
	{
		$CI = &get_instance();

		$CI->db->order_by('created', 'DESC');
		$arr_media = $CI->db_model->get('media');

		foreach($arr_media as $k => $media)
		{
			$arr_media[$k]->path = CONTENTURL . '/' . substr($media->created, 0 ,4) . '/' . substr($media->created, 5 ,2);

			if($media->vendor == 'Youtube')
			{
				$parts = parse_url($media->url);
				parse_str($parts['query'], $query);

				$arr_media[$k]->image_thumb = 'https://img.youtube.com/vi/' . $query['v'] . '/0.jpg';
			}
		}

		$html_temp = '';

		foreach($arr_media as $media)
		{
			$ext = pathinfo($media->path . '/' . $media->name, PATHINFO_EXTENSION);
			$name = basename($media->path . '/' . $media->name, '.' . $ext);

			$html_temp .= '<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">';
			
			if($media->vendor == 'Youtube')
			{
				$html_temp .= '<a href="#" class="img-add-image-on-click" data-id="' . $media->id . '" data-vendor="' . $media->vendor . '" data-fileurl="' . $media->url . '"><img src="' . $media->image_thumb . '" class="img-thumbnail media-thumbs"></a>';
			}
			else
			{
				$html_temp .= '<a href="#" class="img-add-image-on-click" data-id="' . $media->id . '" data-vendor="' . $media->vendor . '" data-fileurl="' . $media->path . '/' . $name . '-600' . '.' . $ext . '"><img src="' . $media->path . '/' . $name . '-cropped' . '.' . $ext . '" class="img-thumbnail media-thumbs"></a>';
			}

			$html_temp .= '</div>';
		}

		if(count($arr_media) <= 0)
		{
			$html_temp = '';
			$html_temp .= '<div style="width: 100%; text-align: center; margin-top: 20px">';
			$html_temp .= '<h5>Media is empty</h5>';
			$html_temp .= '</div>';
		}

		$auth_add_media = $CI->user_access->verify('media', 'add');

		$from_media = '';
		$from_media .= '<div class="row">';
		$from_media .= '<div id="modal-body-scroll" class="col-md-12">';
		$from_media .= $html_temp;
		$from_media .= '</div>';
		$from_media .= '</div>';

		$upload_new = '';
		$upload_new .= '<div class="row">';
		$upload_new .= '<div class="col-md-12">';
		$upload_new .= '<form id="form_image_upload" action="' . site_url('media/ajax_add_image') . '" class="dropzone">';
		$upload_new .= '<input type="hidden" name="vendor" value="Hosted">';
		$upload_new .= '<input type="hidden" name="storage" value="Internal">';
		$upload_new .= '</form>';
		$upload_new .= '</div>';
		$upload_new .= '</div>';

		$html = '';
		$html .= '<div class="nav-tabs-custom">';
		$html .= '<ul class="nav nav-tabs" role="tablist">';
		$html .= '<li role="presentation" class="active"><a href="#from-media" aria-controls="home" role="tab" data-toggle="tab">Media</a></li>';
		
		if($auth_add_media)
		{
			$html .= '<li role="presentation"><a id="upload_new_tab_content" href="#upload-new" aria-controls="profile" role="tab" data-toggle="tab">Upload New Image</a></li>';
		}

		$html .= '</ul>';

		$html .= '<div class="tab-content">';
		$html .= '<div role="tabpanel" class="tab-pane active" id="from-media">' . $from_media . '</div>';
		
		if($auth_add_media)
		{
			$html .= '<div role="tabpanel" class="tab-pane" id="upload-new">' . $upload_new . '</div>';
		}

		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}
}