<?php

/**
 * Brightcove PHP MAPI Wrapper Caching Layer 1.0.0 (12 OCTOBER 2010)
 *
 * REFERENCES:
 *	 Website: http://opensource.brightcove.com
 *	 Source: http://github.com/brightcoveos
 *
 * AUTHORS:
 *	 Matthew Congrove <mcongrove@brightcove.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the �Software�),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, alter, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to permit persons to
 * whom the Software is furnished to do so, subject to the following conditions:
 *   
 * 1. The permission granted herein does not extend to commercial use of
 * the Software by entities primarily engaged in providing online video and
 * related services.
 *  
 * 2. THE SOFTWARE IS PROVIDED "AS IS", WITHOUT ANY WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, SUITABILITY, TITLE,
 * NONINFRINGEMENT, OR THAT THE SOFTWARE WILL BE ERROR FREE. IN NO EVENT
 * SHALL THE AUTHORS, CONTRIBUTORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
 * CLAIM, DAMAGES OR OTHER LIABILITY WHATSOEVER, WHETHER IN AN ACTION OF
 * CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH
 * THE SOFTWARE OR THE USE, INABILITY TO USE, OR OTHER DEALINGS IN THE SOFTWARE.
 *  
 * 3. NONE OF THE AUTHORS, CONTRIBUTORS, NOR BRIGHTCOVE SHALL BE RESPONSIBLE
 * IN ANY MANNER FOR USE OF THE SOFTWARE.  THE SOFTWARE IS PROVIDED FOR YOUR
 * CONVENIENCE AND ANY USE IS SOLELY AT YOUR OWN RISK.  NO MAINTENANCE AND/OR
 * SUPPORT OF ANY KIND IS PROVIDED FOR THE SOFTWARE.
 */

class BCMAPICache
{
	public $extension = NULL;
	public $location = NULL;
	public $memcached = NULL;
	public $port = NULL;
	public $time = 0;
	public $type = NULL;

	/**
	 * The constructor for the BCMAPICache class.
	 * @access Public
	 * @since 1.0.0
	 * @param string [$type] The type of caching method to use, either 'file' or 'memcached'
	 * @param int [$time] How many seconds until cache files are considered cold
	 * @param string [$location] The absolute path of the cache directory (file) or host (memcached)
	 * @param string [$extension] The file extension for cache items (file only)
	 * @param int [$port] The port to use (Memcached only)
	 */
	public function __construct($type = 'file', $time = 600, $location, $extension = '.c', $port = 11211)
	{
		
		if(strtolower($type) == 'file')
		{
			$type = 'file';
		} else if(strtolower($type) == 'memcache' || strtolower($type) == 'memcached') {
			$type = 'memcached';
			
			$memcached = new Memcached();
			$memcached->addServer($location, $port);
			
			$this->memcached = $memcached;
		} else {
			$type = FALSE;
		}
		
		$this->extension = $extension;
		$this->location = $location;
		$this->port = $port;
		$this->time = $time;
		$this->type = $type;
	}

	/**
	 * Retrieves any valid cached data.
	 * @access Public
	 * @since 1.0.1
	 * @param string [$key] The cache file key
	 * @return mixed The cached data if valid, otherwise FALSE
	 */
	public function get($key)
	{
		if($this->type == 'file')
		{
			$file = $this->location . md5($key) . $this->extension;
	
			if(file_exists($file) && is_readable($file))
			{
				if((time() - filemtime($file)) <= $this->time)
				{
					return file_get_contents($file);
				}
			}
			
			return FALSE;
		} else if($this->type == 'memcached') {
			$data = $this->memcached->get($key);
			
			if($this->memcached->getResultCode() == Memcached::RES_SUCCESS)
			{
				return $data;
			}
		} else {
			return FALSE;
		}
	}

	/**
	 * Creates a cache of data.
	 * @access Public
	 * @since 1.0.0
	 * @param string [$key] The cache file key
	 * @param mixed [$data] The data to cache
	 */
	public function set($key, $data)
	{
		if($this->type == 'file')
		{
			$file = $this->location . md5($key) . $this->extension;
	
			if(is_writable($this->location))
			{
				$handle = fopen($file, 'w');
				fwrite($handle, json_encode($data));
				fclose($handle);
			}
		} else if($this->type == 'memcached') {
			$this->memcached->set($key, $data, time() + $this->time);
		} else {
			return FALSE;
		}
	}
}

?>