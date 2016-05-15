<?php
/**
*
* @package Limit Posts Per User
* @copyright (c) 2015 dbk (budiselic@vodafone.de)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dbk\limitpostsperuser\controller;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
* Admin controller
*/
class admin_controller implements admin_interface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var ContainerInterface */
	protected $container;

	/** @var string Custom form action */
	protected $u_action;

	/**
	* Constructor for admin controller
	*
	* @param \phpbb\config\config		$config		Config object
	* @param \phpbb\request\request		$request	Request object
	* @param \phpbb\template\template	$template	Template object
	* @param \phpbb\user				$user		User object
	* @param ContainerInterface			$container	Service container interface
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, ContainerInterface $container)
	{
		$this->config		= $config;
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;
		$this->container	= $container;
	}

	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options()
	{
		// Create a form key for preventing CSRF attacks
		$form_key = 'limitpostsperuser';
		add_form_key($form_key);

		//$this->config_text = $this->container->get('config_text');

		// Is the form being submitted
		if ($this->request->is_set_post('submit'))
		{
			// Is the submitted form valid
			if (!check_form_key($form_key))
			{
				trigger_error($this->user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// If no errors, process the form data
			// Set the options the user configured
			$this->set_options();

			// Add option settings change action to the admin log
			$phpbb_log = $this->container->get('log');
			$phpbb_log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LPPU_LOG');

			// Option settings have been updated and logged
			// Confirm this to the user and provide link back to previous page
			trigger_error($this->user->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		// Set output vars for display in the template
		$this->template->assign_vars(array(
			'LPPU_ENABLE'				=> isset($this->config['lppu_enable']) ? $this->config['lppu_enable'] : '',
			'LPPU_PER_DAY_CHECK'		=> isset($this->config['lppu_per_day_check']) ? $this->config['lppu_per_day_check'] : '',
			'LPPU_PER_DAY_SETTINGS'		=> isset($this->config['lppu_per_day_settings']) ? $this->config['lppu_per_day_settings'] : '',
			'LPPU_PER_WEEK_CHECK'		=> isset($this->config['lppu_per_week_check']) ? $this->config['lppu_per_week_check'] : '',
			'LPPU_PER_WEEK_SETTINGS'	=> isset($this->config['lppu_per_week_settings']) ? $this->config['lppu_per_week_settings'] : '',
			'LPPU_PER_MONTH_CHECK'		=> isset($this->config['lppu_per_month_check']) ? $this->config['lppu_per_month_check'] : '',
			'LPPU_PER_MONTH_SETTINGS'	=> isset($this->config['lppu_per_month_settings']) ? $this->config['lppu_per_month_settings'] : '',
			'LPPU_EXCLUDED_RANK_IDS'	=> isset($this->config['lppu_excluded_rank_ids']) ? $this->config['lppu_excluded_rank_ids'] : '',
			'LPPU_INCLUDED_GROUP_IDS'	=> isset($this->config['lppu_included_group_ids']) ? $this->config['lppu_included_group_ids'] : '',
			'U_ACTION' 					=> $this->u_action,
		));
	}

	/**
	* Set the options a user can configure
	*
	* @return null
	* @access protected
	*/
	protected function set_options()
	{
		$this->config->set('lppu_enable', $this->request->variable('lppu_enable', 0));
		$this->config->set('lppu_per_day_check', $this->request->variable('lppu_per_day_check', 0));
		$this->config->set('lppu_per_day_settings', $this->request->variable('lppu_per_day_settings', ''));
		$this->config->set('lppu_per_week_check', $this->request->variable('lppu_per_week_check', 0));
		$this->config->set('lppu_per_week_settings', $this->request->variable('lppu_per_week_settings', ''));
		$this->config->set('lppu_per_month_check', $this->request->variable('lppu_per_month_check', 0));
		$this->config->set('lppu_per_month_settings', $this->request->variable('lppu_per_month_settings', ''));
		$this->config->set('lppu_excluded_rank_ids', $this->request->variable('lppu_excluded_rank_ids', ''));
		$this->config->set('lppu_included_group_ids', $this->request->variable('lppu_included_group_ids', ''));
	}


	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
