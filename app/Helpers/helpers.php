<?php

/**
 * Application helpers file
 */

function hasPermission($permission_name) {
	return \Auth::user()->type == \App\User::SUPER_ADMIN ?: \Entrust::can($permission_name);
}