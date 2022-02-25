<?php

if (!defined('APP_NAME'))                       define('APP_NAME', 'Copious Security Vault');
if (!defined('APP_DESCRIPTION'))                define('APP_DESCRIPTION', 'Flexible property protection and logistics company.');
if (!defined('APP_KEYWORDS'))                   define('APP_KEYWORDS', 'security, vault');
if (!defined('APP_URL'))                        define('APP_URL', 'http://domain.com/');

if (!defined('BASE_PATH'))                      define('BASE_PATH', __DIR__ . '/');

if (!defined('ALLOWED_INACTIVITY_TIME'))        define('ALLOWED_INACTIVITY_TIME', time() + 1 * 60);

if (!defined('DB_DATABASE'))                    define('DB_DATABASE', 'emma1');
if (!defined('DB_HOST'))                        define('DB_HOST', 'localhost');
if (!defined('DB_USERNAME'))                    define('DB_USERNAME', 'root');
if (!defined('DB_PASSWORD'))                    define('DB_PASSWORD', '');
if (!defined('DB_PORT'))                        define('DB_PORT', '3306');

if (!defined('MAIL_HOST'))                      define('MAIL_HOST', 'smtp.gmail.com');
if (!defined('MAIL_USERNAME'))                  define('MAIL_USERNAME', 'mailaddress@mail.com');
if (!defined('MAIL_PASSWORD'))                  define('MAIL_PASSWORD', 'mailpassword');
if (!defined('MAIL_ENCRYPTION'))                define('MAIL_ENCRYPTION', 'ssl');
if (!defined('MAIL_PORT'))                      define('MAIL_PORT', 465);
