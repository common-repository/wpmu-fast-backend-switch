<?php
/*
	Copyright 2010 Nicolas Kuttler (email : wp@nicolaskuttler.de )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

Plugin Name: MU fast backend switch
Author: Nicolas Kuttler
Author URI: http://www.nkuttler.de/
Plugin URI: http://www.nkuttler.de/wordpress/
Description: Switch between the backends of your MU blogs with one click 
Version: 0.2.0.2
License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

/**
 * Create switch links and redirect
 *
 * @package mu_fast_backend_switch
 * @since 0.1
 * @todo test with paths!
 * @todo could admin_menu be too late to redirect?
 */
function mu_fast_backend_switch() {
	if( isset( $_GET['mu_fast_backend_switch_domain'] ) ) {
		$domain	= $_GET['mu_fast_backend_switch_domain'];
		$path	= $_GET['mu_fast_backend_switch_path'];
		wp_redirect( 'http://' . $domain . $path );
	}

	$blogs = get_blog_list();
	if ( count( $blogs ) > 50 ) // you never know...
		return;

	foreach ( $blogs as $blog ) {
		$detail = get_blog_details( $blog['blog_id'] );
		$name	= $detail->blogname;
		$domain	= $detail->domain;
		#$path	= $detail->path;
		$path	= $_SERVER['REQUEST_URI'];

		add_submenu_page( 'ms-admin.php', 'Super Admin', $name, 'manage_options', "ms-admin.php?mu_fast_backend_switch_domain=${domain}&amp;mu_fast_backend_switch_path=${path}" );
	}
}

if ( is_admin() ) 
	add_action( 'admin_menu', 'mu_fast_backend_switch' );
