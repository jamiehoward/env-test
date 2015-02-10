<?php
function checkEnvFile($file) {
	$handle = file($file);
	$envVariables = [];
	foreach ($handle as $var):
		if ( strpos($var, "=") ):
			$var = explode('=', $var);
			$envVariables[$var[0]] = $var[1];
		endif;
        endforeach;
    
	$required = ['APP_ENV', 'DB_HOST', 'DB_NAME', 'DB_PASS', 'DB_USER'];
	foreach ($required as $var):
		if ( ! array_key_exists($var, $envVariables) || ! $envVariables[$var] || count($envVariables) < count($required) ):	
			throw new Exception('Invalid environment configuration');
		else:
			// Environment variable exists, so register it
			$_ENV[$var] = trim($envVariables[$var]);
		endif;
	endforeach;
}

try {
	checkEnvFile('.env');
} catch (Exception $e) {
	echo 'Caught exception: ', $e->getMessage(), "\n";
}

var_dump($_ENV);
exit();
