<?php

namespace Ardiran\Core\Ajax\Traits;

trait Response {

    public function JSONResponse($response){
		wp_send_json($response);
	}

}