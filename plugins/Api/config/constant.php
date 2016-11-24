<?php

// API Status
if (!defined('API_STATUS_SUCCESS')) {define('API_STATUS_SUCCESS', 'success');}
if (!defined('API_STATUS_ERROR')) {define('API_STATUS_ERROR', 'error');}

// Error code
if (!defined('ERROR_INVALID_AUTH')) {define('ERROR_INVALID_AUTH', '001');}
if (!defined('ERROR_INVALID_MISSING_PARAM')) {define('ERROR_INVALID_MISSING_PARAM', '002');}
if (!defined('ERROR_INVALID_VALIDATION')) {define('ERROR_INVALID_VALIDATION', '003');}
if (!defined('ERROR_INVALID_JSON_OBJECT')) {define('ERROR_INVALID_JSON_OBJECT', '004');}
if (!defined('ERROR_INVALID_POST_DATA')) {define('ERROR_INVALID_POST_DATA', '005');}
if (!defined('ERROR_INVALID_PAGE_RANGE')) {define('ERROR_INVALID_PAGE_RANGE', '006');}

if (!defined('ERROR_EXCEPTION_USER_BLOCK')) {define('ERROR_EXCEPTION_USER_BLOCK', '901');}
if (!defined('ERROR_EXCEPTION_USER_INVALID')) {define('ERROR_EXCEPTION_USER_INVALID', '902');}

$errorCode = [
    ERROR_INVALID_AUTH => 'Invalid user auth',
    ERROR_INVALID_MISSING_PARAM => 'Missing parameter(s)',
    ERROR_INVALID_VALIDATION => 'Validation is invalid',
    ERROR_INVALID_JSON_OBJECT => 'Invalid json object',
    ERROR_INVALID_POST_DATA => 'Invalid post data. Post data must be: data={json_object}',
    ERROR_INVALID_PAGE_RANGE => 'The paginate is out of range',
    
    ERROR_EXCEPTION_USER_BLOCK => 'Your account has been blocked',
    ERROR_EXCEPTION_USER_INVALID => 'Invalid email or password',
];
    
Cake\Core\Configure::write('E', $errorCode);
?>