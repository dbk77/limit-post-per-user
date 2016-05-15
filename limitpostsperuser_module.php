<?php
/**
*
* @package Limit Posts Per User
* @copyright (c) 2015 dbk (budiselic@vodafone.de)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dbk\limitpostsperuser\acp;

class limitpostsperuser_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container, $user;

		$this->tpl_name		= 'limitpostsperuser';
		$this->page_title	= $user->lang('LIMIT_POSTS_PER_USER');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('dbk.limitpostsperuser.admin.controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		$admin_controller->display_options();
	}
}
