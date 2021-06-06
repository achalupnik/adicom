<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('asset_url'))
{
	function asset_url($uri = '', $group = FALSE)
	{
		$CI = & get_instance();
        
        	if ( ! $dir = $CI->config->item('assets_path'))
        	{
			$dir = 'assets/';
		}

		if ($group)
		{
			return $CI->config->base_url($dir . $group . '/' . $uri);
		}
		else
		{
			return $CI->config->base_url($dir . $uri);
		}
	}
}

if ( ! function_exists('css_url'))
{
	function css_url($uri = '', $group = FALSE)
	{
		return asset_url('css/' . $uri, $group);
	}
}

if ( ! function_exists('img_url'))
{
	function img_url($uri = '', $group = FALSE)
	{
		return asset_url('img/' . $uri, $group);
	}
}

if ( ! function_exists('js_url'))
{
	function js_url($uri = '', $group = FALSE)
	{
		return asset_url('js/' . $uri, $group);
	}
}

if ( ! function_exists('css_link'))
{
	function css_link($uri, $group = FALSE, $media = 'all', $before = '', $after = '')
	{
		$link = array(
           		'href'	=> (strpos($uri, '://') === FALSE ? css_url($uri, $group) : $uri).'?v='.filemtime('assets/'.$group.'/css/'.$uri),
           		'rel'	=> 'stylesheet',
           		'type'	=> 'text/css',
           		'media'	=> $media
		);
		return $before . link_tag($link) . $after;
	}
}

if ( ! function_exists('img_link'))
{
	function img_link($uri, $group = FALSE, $attr = array())
	{
		$img = array('src' => (strpos($uri, '://') === FALSE ? img_url($uri, $group) : $uri));
		
		if(is_array($attr))
		{
			$img = array_merge($attr, $img);
		}
		
		return img($img);
	}
}

if ( ! function_exists('js_link'))
{
	function js_link($uri, $group = FALSE)
	{
		return '<script type="text/javascript" src="' . (strpos($uri, '://') === FALSE ? js_url($uri, $group) : $uri).'?v='.filemtime('assets/'.$group.'/js/'.$uri).'"></script>';
	}
}
