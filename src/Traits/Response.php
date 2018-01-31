<?php

namespace Ardiran\Core\Traits;

trait Response {

    public function JSONResponse($response){
		wp_send_json($response);
	}

}