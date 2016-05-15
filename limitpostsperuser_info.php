<?php
/**
*
* @package Limit Posts Per User
* @copyright (c) 2015 dbk (budiselic@vodafone.de)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dbk\limitpostsperuser\acp;

class limitpostsperuser_info
{
	function module()
	{
		return array(
			'filename'	=> '\dbk\limitpostsperuser\acp\limitpostsperuser_module',
			'title'		=> 'LIMIT_POSTS_PER_USER',
			'modes'		=> array(
				'main'	=> array('title' => 'LPPU_SETTINGS', 
								'auth' => 'ext_dbk/limitpostsperuser && acl_a_board', 
								'cat' => array('LIMIT_POSTS_PER_USER')),
			),
		);
	}
}
