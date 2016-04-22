<?php
/**
 * ORGA Server
 * @link https://github.com/marcowuelser/orga_server
 * @copyright (c) 2016 @author Marco Wuelser @license MIT (see /LICENSE)
 *
 * This file contains error code definitions.
 *
 * TODO: Use ErrorCodeEnum instead and remove this !.
 */

declare(strict_types=1);

use \Psr\Http\Message\ResponseInterface as Response;

include_once('util.php');

function getErrorName(int $errorCode) : string
{
    $errorCodes = array(
                1001 => "Specific entry not found",
                1002 => "No data found",
                1003 => "Invalid request",

                2001 => "Database Exception",
                2002 => "Unimplemented",

                3001 => "Login failed",
                3002 => "Not Authorized",
    );

    if (array_key_exists($errorCode, $errorCodes))
    {
        return $errorCodes[$errorCode];
    }

    return "Unknown error";
}

// http://www.restapitutorial.com/httpstatuscodes.html
function getHttpStatusCode(int $errorCode) : int
{
    $errorCodes = array(
                1001 => 404,
                1002 => 404,
                1003 => 400, // Client Error

                2001 => 500, // Internal Server Error
                2002 => 500, // Internal Server Error

                3001 => 401, // Unauthorized
                3002 => 403, // Forbidden
    );

    if (array_key_exists($errorCode, $errorCodes))
    {
        return $errorCodes[$errorCode];
    }

    return 500;
}

function createErrorResponse(int $errorCode, string $description) : array
{
    $data = array(
        "code" => $errorCode,
        "http_status_code" => getHttpStatusCode($errorCode),
        "error" => getErrorName($errorCode),
        "description" => $description,
    );
    return $data;
}

function responseWithJsonError(Response $response, int $errorCode, string $description) : Response
{
    $data = createErrorResponse($errorCode, $description);
    return responseWithJson($response, $data);
}

?>
