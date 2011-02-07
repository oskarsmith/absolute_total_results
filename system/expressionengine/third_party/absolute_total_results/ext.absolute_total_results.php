<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Absolute_total_results_ext
{
	public $settings = array();
	public $name = 'Absolute Total Results';
	public $version = '1.0.0';
	public $description = 'Adds an {absolute_total_results} tag to channel:entries, for use with pagination.';
	public $settings_exist = 'y';
	public $docs_url = 'http://barrettnewton.com';
	
	/**
	 * __construct
	 * 
	 * @access	public
	 * @param	mixed $settings = ''
	 * @return	void
	 */
	public function __construct($settings = '')
	{
		$this->EE = get_instance();
		
		$this->settings = $settings;
	}
	
	/**
	 * activate_extension
	 * 
	 * @access	public
	 * @return	void
	 */
	public function activate_extension()
	{
		$hook_defaults = array(
			'class' => __CLASS__,
			'settings' => '',
			'version' => $this->version,
			'enabled' => 'y',
			'priority' => 10
		);
		
		$hooks[] = array(
			'method' => 'channel_entries_tagdata_end',
			'hook' => 'channel_entries_tagdata_end'
		);
		
		foreach ($hooks as $hook)
		{
			$this->EE->db->insert('extensions', array_merge($hook_defaults, $hook));
		}
	}
	
	/**
	 * update_extension
	 * 
	 * @access	public
	 * @param	mixed $current = ''
	 * @return	void
	 */
	public function update_extension($current = '')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
		
		$this->EE->db->update('extensions', array('version' => $this->version), array('class' => $this->classname));
	}
	
	/**
	 * disable_extension
	 * 
	 * @access	public
	 * @return	void
	 */
	public function disable_extension()
	{
		$this->EE->db->delete('extensions', array('class' => $this->classname));
	}
	
	/**
	 * settings
	 * 
	 * @access	public
	 * @return	void
	 */
	public function settings()
	{
		$settings = array();
		
		return $settings;
	}
        
	/**
	 * settings
	 * 
	 * @access	public
	 * @param	string $tagdata
	 * @param	array $row
	 * @param	Channel $channel
	 * @return	string
	 */
        public function channel_entries_tagdata_end($tagdata, $row, $channel)
        {
		if ($this->EE->extensions->last_call !== FALSE)
		{
			$tagdata = $this->EE->extensions->last_call;
		}
		
		$tagdata = $this->EE->TMPL->swap_var_single('absolute_total_results', $channel->total_rows, $tagdata);
		
		return $tagdata;
        }
}

/* End of file ext.absolute_total_results.php */
/* Location: ./system/expressionengine/third_party/absolute_total_results/ext.absolute_total_results.php */