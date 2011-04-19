<?php


/**
 *
 * LICENCE INFO
 * @author Gazler
 *
 */
class Grabbio
{
	private $_apiKey;
	private $_secretKey;

	//Arguments passed to the API request are stored in an array
	private $_args = array();



	/**
	 * Initialize grabbio object
	 * @param String $apiKey		Users API Key
	 * @param String $secretKey		Users API Secret
	 */
	public function __construct($apiKey, $secretKey)
	{
		$this->_apiKey = $apiKey;
		$this->_secretKey = $secretKey;
	}

	/**
	 * Toggle Developer Mode
	 * @link http://grabb.io/documentation#documentation_developer_mode
	 * @param Boolean $developerMode	When true thumbnails are free but watermarked.
	 */
	public function developerMode($developerMode = true)
	{
		$this->_args['developer_mode'] = (int)$developerMode;
		return $this;
	}

	/**
	 * Set number of Thumbnails
	 * @link http://grabb.io/documentation#documentation_number_of_thumbnails
	 * @param Integer $numberOfThumbnails	Number of thumbnails you require.  For gif each thumbnails is a frame.
	 */
	public function numberOfThumbnails($numberOfThumbnails = 1)
	{
		$this->_args['number_of_thumbnails'] = $numberOfThumbnails;
		return $this;
	}

	/**
	 * Set width of generated thumbnails
	 * @link http://grabb.io/documentation#documentation_width
	 * @param Integer $width	Desired width of generated thumbnails
	 */
	public function width($width = 120)
	{
		$this->_args['width'] = $width;
		return $this;
	}

	/**
	 * Set height of generated thumbnails
	 * @link http://grabb.io/documentation#documentation_width
	 * @param Integer $height	Desired height of generated thumbnails
	 */
	public function height($height)
	{
		$this->_args['height'] = $height;
		return $this;
	}

	/**
	 * Set the source URL of your video.
	 * @link http://grabb.io/documentation#documentation_width
	 * @param String $source	HTTP and RTMP videos are valid.
	 */
	public function source($source)
	{
		$this->_args['source'] = $source;
		return $this;
	}

	/**
	 * Set the upload destination of the thumbnails  FTP is accepted in the format ftp://USERNAME:PASSWORD@HOST.  S3 is accepted in the format S3://BUCKET_NAME.
	 * @link http://grabb.io/documentation#documentation_upload_url
	 * @param String $uploadUrl		S3 and FTP are valid
	 */
	public function uploadUrl($uploadUrl)
	{
		$this->_args['upload_url'] = $uploadUrl;
		return $this;
	}


	/**
	 * Whether Individual thumbnails should be generated and uploaded.
	 * @link http://grabb.io/documentation#documentation_thumbnail_styles
	 * @param Boolean $individual
	 */
	public function createIndividual($individual = true)
	{
	    if ($individual == true)
        {
            $this->_setThumbnailMode('individual');
        }
        else
        {
            $this->_setThumbnailMode('individual', false);
        }
		return $this;
	}

	/**
	 * Which scale mode to use.  Please visit the link for detailed descriptions.
	 * @link http://grabb.io/documentation#documentation_scale_mode
	 * @param String $mode			The scale mode to use.  Possible values are pad, stretch or crop
	 * @param String $padColor		Used when scale_mode is set to pad  This is the background color used.  When using PNGs, this can also be 'transparent'
	 */
	public function scaleMode($mode, $padColor = "#000000")
	{
		$this->_args['scale_mode'] = $mode;
		$this->_args['pad_color'] = $padColor;
		return $this;
	}

	/**
	 * Pad color to use.  This value is only used when the scale_mode is set to pad.
	 * @link http://grabb.io/documentation#documentation_pad_color
	 * @param String $padColor 		The pad Color to use.  Possible values are color strings, hex strings (#FF00FF) and transparent.
	 */
	public function padColor($padColor = "#000000")
	{
		$this->_args['pad_color'] = $padColor;
		return $this;
	}

	/**
	 * Whether Placeholders are uploaded while your video is processing.
	 * @link http://grabb.io/documentation#documentation_upload_placeholders
	 * @param Boolean $uploadPlaceholders
	 */
	public function uploadPlaceHolders($uploadPlaceholders = true)
	{
		$this->_args['upload_placeholders'] = (int)$uploadPlaceholders;
		return $this;
	}

	/**
	 * Callback URL to use.  If set, grabbio will send an HTTP POST with a parameter of message to this URL.
	 * @link http://grabb.io/documentation#documentation_callback_url
	 * @param Boolean $callBackurl	URL which you wish to be notified on.
	 */
	public function callbackUrl($callbackUrl)
	{
		$this->_args['callback_url'] = $callbackUrl;
		return $this;
	}

	/**
	 * Whether to create a capsheet.  If $capsheetColumns is false then a capsheet will not be generated.
	 * @link http://grabb.io/documentation#documentation_thumbnail_styles
	 * @param Mixed $capsheetColumns		If false then a capsheet is not generated.  Otherwise the integer value is used as the number of columns the capsheet uses.
	 * @param Boolean $capsheetVideoInfo	If the capsheet should show video information at the top of the image.
	 * @param Boolean $capsheetTimestamp	If the capsheet should display timestamps on thumbnails.
	 */
	public function createCapsheet($capsheetColumns = "3", $capsheetVideoInfo = true, $capsheetTimestamp = true)
	{
        if ($capsheetColumns == false)
        {
            unset($this->_args['capsheet_columns']);
            unset($this->_args['capsheet_video_info']);
            unset($this->_args['capsheet_timestamp']);
            $this->_setThumbnailMode('capsheet', false);
        }
        else
        {
            $this->_args['capsheet_columns'] = $capsheetColumns;
            $this->_args['capsheet_video_info'] = (int)$capsheetVideoInfo;
            $this->_args['capsheet_timestamp'] = (int)$capsheetTimestamp;
            $this->_setThumbnailMode('capsheet');
        }
        return $this;
	}

	/**
	 * Number of columns to use in the capsheet.
	 * @link http://grabb.io/documentation#documentation_capsheet_columns
	 * @param Integer $capsheetColumns	Number of columns to use on the capsheet.
	 */
	public function capsheetColumns($capsheetColumns)
	{
        $this->_args['capsheet_columns'] = $capsheetColumns;
        return $this;
	}

	/**
	 * Whether to display the capsheet video information.
	 * @link http://grabb.io/documentation#documentation_capsheet_video_info
	 * @param Boolean $capsheetVideoInfo		If the capsheet should show video information at the top of the image.
	 */
	public function capsheetVideoInfo($capsheetVideoInfo)
	{
        $this->_args['capsheet_video_info'] = (int)$capsheetVideoInfo;
        return $this;
	}

	/**
	 * Whether to display timestamps on the capsheet thumbnails.
	 * @link http://grabb.io/documentation#documentation_capsheet_timestamps
	 * @param Boolean $capsheetVideoInfo		If the capsheet should display timestamps on thumbnails.
	 */
	public function capsheetTimestamp($capsheetTimestamp)
	{
        $this->_args['capsheet_timestamp'] = (int)$capsheetTimestamp;
        return $this;
	}

	/**
	 * Whether to create an animated gif.  If $gifFramerate is false then an animated gif will not be generated.
	 * @link http://grabb.io/documentation#documentation_thumbnail_styles
	 * @param Mixed $gifFramerate		If false then an animted gif is not generated.  Otherwise the integer value is used as the delay between frames in the animated gif.
	 */
	public function createGif($gifFramerate = 30)
	{
        if ($gifFramerate == false)
        {
            unset($this->_args['gif_framerate']);
            $this->_setThumbnailMode('gif', false);
        }
        else
        {
            $this->_args['gif_framerate'] = $gifFramerate;
            $this->_setThumbnailMode('gif');
        }
        return $this;
    }

	/**
	 * Delay between frames in the animated GIF.
	 * @link http://grabb.io/documentation#documentation_gif_framerate
	 * @param Integer $gifFramerate		The delay between frames in the animated gif.
	 */
	public function gifFrameRate($gifFramerate)
	{
        $this->_args['gif_framerate'] = $gifFramerate;
		return $this;
	}

	/**
	 * Make the API Request
	 * @param String $source		If set, this source URL will be used.
	 * @param String $uploadUrl		If set, this upload URL will be used.
	 * @param Integer $width		If set, this width will be used.
	 * @param Integer $height		If set, this height will be used.
	 * @throws GrabbioException
	 */
	public function grab($source = false, $uploadUrl = false, $width = 120, $height = 90)
	{
	    if ($source === false)
	    {
	        if (!array_key_exists('source', $this->_args))
	        {
	           throw new GrabbioException("Source URL Missing");
	        }
	    }

	    if ($uploadUrl === false)
	    {
	        if (!array_key_exists('upload_url', $this->_args))
	        {
	           throw new GrabbioException("Upload URL Missing");
	        }
	    }

	    if ($width === 120)
	    {
	        if (!array_key_exists('width', $this->_args))
	        {
	           $this->_args['width'] = $width;
	        }
	    }
	    else
	    {
	        $this->_args['width'] = $width;
	    }

	    if ($height === 90)
	    {
	        if (!array_key_exists('height', $this->_args))
	        {
	           $this->_args['height'] = $width;
	        }
	    }
	    else
	    {
	        $this->_args['height'] = $width;
	    }


		return $this->_processResponse($this->_makeCall());
	}

	/**
	 * Sign the parameters and make the request.
	 */
	private function _makeCall()
	{
        $request =  'http://grabb.io/api/v1/videos.json';
        $args = $this->_argsToString();
        $args .= "&token=".$this->_apiKey;
        $args .= "&server_time=".time();
        $hash =  base64_encode(hash_hmac("SHA1", substr($args, 1), $this->_secretKey, 1));
       	$args .= "&hash=".$hash;
        $session = curl_init($request.$args);

        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($session);
        curl_close($session);
		return $response;
	}

	/**
	 * Convert the arguments array to a string for the API request.
	 */
	private function _argsToString()
	{
        $first = true;
        $args = "";
        foreach($this->_args as $key => $value)
        {
        	if ($first)
        	{
        		$first = false;
        		$args .= "?";
        	}
        	else
        	{
        		$args .= "&";
        	}
        	$args .= $key."=".$value;
        }
        return $args;
	}

	/**
	 * Enable/Disable thumbnail types.
	 * @param String $mode		Allowed values are individual, gif or capsheet.
	 * @param Boolean $type		Enable/Disable.
	 */
	private function _setThumbnailMode($mode, $type = true)
	{
	    if (array_key_exists('thumbnail_styles', $this->_args))
	    {
	        $modes = explode(',', $this->_args['thumbnail_styles']);
	    }
	    else
	    {
	        $modes = array();
	    }

	    if ($type == true)
	    {
	        if (!in_array($mode, $modes))
	        {
	            $modes[] = $mode;
	       }
	    }
	    else
	    {
	        if (in_array($mode, $modes))
	        {
	            $modes = array_diff($modes, array($mode));
	        }
	    }

	    if (count($modes) > 0)
	    {
	        $this->_args['thumbnail_styles'] = implode(',', $modes);
	    }
	    else
	    {
	        if (array_key_exists('thumbnail_styles', $this->_args))
	        {
	            unset($this->_args['thumbnail_styles']);
	        }
	    }
	}

	/**
	 * Parse the API response checking for errors.
	 * @param String $response		JSON as string.
	 * @throws GrabbioException
	 */
	private function _processResponse($response)
	{
	    if (!($response = json_decode($response)))
	    {
	        throw new GrabbioException("Invalid JSON response");
	    }
	    if (isset($response->error))
	    {
	        throw new GrabbioException($response->error);
	    }

	    if (isset($response->errors))
	    {
	        $errors = array();
	        foreach((array)$response->errors as $field => $error)
	        {
	            $errors[] = $field." => ".$error;
	        }
	        throw new GrabbioException(implode(", ", $errors));
	    }

	    return $response;
	}
}

/**
 *
 *	Thrown when an API call returns an error
 *
 *	@author Gazler
 */
class GrabbioException extends Exception
{
}

