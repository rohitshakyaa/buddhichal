<?php

namespace App\Http\Helpers;

class ApiResponseHelper
{
  public static function successResponse($message)
  {
    return response()->json([
      'status' => '1',
      'statusCode' => 200,
      'message' => $message
    ]);
  }

  public static function errorResponse($message)
  {
    return response()->json([
      "status" => "0",
      "statusCode" => 403,
      "message" => $message
    ], 403);
  }

  public static function unauthorizedResponse($message)
  {
    return response()->json([
      "status" => "0",
      "statusCode" => 401,
      "message" => $message
    ], 401);
  }

  public static function validationErrorResponse($message)
  {
    return response()->json([
      "status" => "0",
      "statusCode" => 422,
      "message" => $message
    ], 422);
  }

  public static function successResponseWithData($data, $message = "Data Found")
  {
    return response()->json([
      "status" => "1",
      "statusCode" => 200,
      "message" => $message,
      "response" => $data,
    ]);
  }

  public static function notFoundResponse($message = "No Data Available")
  {
    return response()->json([

      'status'    => "0",
      'statusCode' => 404,
      'message'   => $message
    ], 404);
  }

  public static function methodNotAllowedResponse($message = "Method not allowed.")
  {
    return response()->json([

      'status'    => "0",
      'statusCode' => 405,
      'message'   => $message
    ], 405);
  }
}
