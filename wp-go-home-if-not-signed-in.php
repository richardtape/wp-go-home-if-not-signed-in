<?php

/*
 * Plugin Name: WP Go Home If Not Signed In
 * Description: Redirect users to the home page if they are not signed in
 * Version:     0.1
 * Plugin URI:  https://github.com/richardtape/wp-go-home-if-not-signed-in
 * Author:      Richard Tape
 * Author URI:  https://richardtape.com/
 * Text Domain: wpghinsi
 * License:     GPL v2 or later
 * Domain Path: languages
 *
 * wpghinsi is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * wpghinsi is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with wpghinsi. If not, see <http://www.gnu.org/licenses/>.
 *
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Nothing here for wp-cli
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	return;
}

class RT_Go_Home_If_Not_Signed_In {

	/**
	 * Initiazlie ourselves by setting up constants and hooks
	 *
	 * @since 1.0.0
	 *
	 * @param null
	 * @return null
	 */

	public function init() {

		// Set up actions and filters as necessary
		$this->add_hooks();

	}/* init() */


	/**
	 * Add our hooks (actions/filters)
	 *
	 * @since 1.0.0
	 *
	 * @param null
	 * @return null
	 */

	public function add_hooks() {

		// Add action hooks
		$this->add_actions();

		// Add filter hooks
		$this->add_filters();

	}/* add_hooks() */


	/**
	 * Add our action hook(s).
	 *
	 * @since 1.0.0
	 *
	 * @param null
	 * @return null
	 */

	public function add_actions() {

		// Redirect as desired
		add_action( 'wp', array( $this, 'wp__redirect' ), 20 );

	}/* add_actions() */


	/**
	 * Add our filter hook(s)
	 *
	 * @since 1.0.0
	 *
	 * @param null
	 * @return null
	 */

	public function add_filters() {

	}/* add_filters() */


	/**
	 * Determine if visitor is signed in. If not, and not on home page, redirect to home page.
	 * Hooked into wp because that's where is_front_page() is available.
	 *
	 * @since 1.0.0
	 *
	 * @param null
	 * @return null
	 */

	public function wp__redirect() {

		if ( ! $this->if_should_redirect() ) {
			return;
		}

		$this->perform_redirect();

	}/* wp__redirect() */


	/**
	 * Determine if we should redirect. Signed in? Don't redirect.
	 * In the admin? Don't redirect. On the home page already?
	 * Don't redirect.
	 *
	 * @since 1.0.0
	 *
	 * @param null
	 * @return bool - False if we should not redirect. True otherwise.
	 */

	public function if_should_redirect() {

		if ( $this->is_admin() ) {
			return false;
		}

		if ( $this->is_user_signed_in() ) {
			return false;
		}

		if ( $this->is_front_page() ) {
			return false;
		}

		return true;

	}/* if_should_redirect() */


	/**
	 * Determine if we're in the dashboard or not.
	 *
	 * @since 1.0.0
	 *
	 * @param null
	 * @return bool
	 */

	public function is_admin() {

		return is_admin();

	}/* is_admin() */


	/**
	 * Determine if the current visitor is signed in or not.
	 *
	 * @since 1.0.0
	 *
	 * @param null
	 * @return bool
	 */

	public function is_user_signed_in() {

		return is_user_logged_in();

	}/* is_user_signed_in() */


	/**
	 * Determine if we're already on the front page or not.
	 *
	 * @since 1.0.0
	 *
	 * @param null
	 * @return bool
	 */

	public function is_front_page() {

		return is_front_page();

	}/* is_front_page() */


	/**
	 * Perform the redirect to the front page.
	 *
	 * @since 1.0.0
	 *
	 * @param null
	 * @return null
	 */

	public function perform_redirect() {

		wp_safe_redirect( get_home_url(), $status );

	}/* perform_redirect() */

}/* class RT_Go_Home_If_Not_Signed_In */

// Set ourselves up.
add_action( 'plugins_loaded', 'rt_wp_go_home_if_not_signed_in' );

/**
 * Initialize our class
 *
 * @since 1.0.0
 *
 * @param null
 * @return null
 */

function rt_wp_go_home_if_not_signed_in() {

	$wpghinsi = new RT_Go_Home_If_Not_Signed_In();
	$wpghinsi->init();

}/* rt_wp_go_home_if_not_signed_in() */
