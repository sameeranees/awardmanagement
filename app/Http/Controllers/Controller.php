<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
	 * Check user permission on controller
	 *
	 * @param      Permission name	$permission
	 */
	function checkPermission($permission) {
		hasPermission($permission) ?: abort(403);
	}


	/**
	 * Global method to change status from listing
	 *
	 * @param      Request  $request  The request
	 */
	public function changeStatus(Request $request){
    	
		try {
			$model = '\App\\'.$request->_model;
			$model = $model::find( $request->_id );
			if (!$model) {
				throw new \Exception( $request->_model." not found." );
			}
			$model->status = $request->status;
			$model->save();
		} catch (\Exception $e) {
			return $e->getMessage();
		}

		return response(['message' => 'status has been changed.']);
	
    }
}
