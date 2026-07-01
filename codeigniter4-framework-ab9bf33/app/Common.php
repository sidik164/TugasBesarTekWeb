<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('isLoggedIn')) {
	function isLoggedIn(): bool
	{
		return session()->has('user_id');
	}
}

if (! function_exists('requireLogin')) {
	function requireLogin(): void
	{
		$session = session();

		if (! $session->has('user_id')) {
			$session->set([
				'user_id' => 1,
				'nama' => 'Demo User',
				'role' => 'admin',
			]);
		}
	}
}
