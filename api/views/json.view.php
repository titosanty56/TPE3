<?php

class JSONView{
    public function response($data, $status = 200){
        header("content_type: application/json");
        $statusText = $this->_requestStatus($status);
        header("HTTP/1.1 $status $statusText");
        echo json_encode($data);
    }

    public function _requestStatus($code){
        $status = Array(
            200=> "OK",
            201=> "Created",
            204=> "No Content",
            400=> "Bad Request",
            401=>"Unauthorized",
            404=> "Not Found",
            500=> "Internal Server Error"
        );
        if (!isset($status[$code])){
            $code = 500;
        }
        return $status[$code];
    }
}