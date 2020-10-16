<?php return array (
  'app' => 
  array (
    'name' => 'Be On Time',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://51.68.139.99',
    'asset_url' => NULL,
    'timezone' => 'Europe/Paris',
    'locale' => 'fr',
    'fallback_locale' => 'fr',
    'faker_locale' => 'en_US',
    'key' => 'base64:Z1shqJgpyPsaOwdaW0W0loe5Hs3qnXyKrmVRwtux+PA=',
    'cipher' => 'AES-256-CBC',
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'App\\Providers\\AppServiceProvider',
      23 => 'App\\Providers\\AuthServiceProvider',
      24 => 'App\\Providers\\EventServiceProvider',
      25 => 'App\\Providers\\RouteServiceProvider',
      26 => 'GoogleMaps\\ServiceProvider\\GoogleMapsServiceProvider',
      27 => 'Cartalyst\\Stripe\\Laravel\\StripeServiceProvider',
      28 => 'Collective\\Html\\HtmlServiceProvider',
      29 => 'Barryvdh\\DomPDF\\ServiceProvider',
      30 => 'Mews\\Captcha\\CaptchaServiceProvider',
      31 => 'Maatwebsite\\Excel\\ExcelServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Helper' => 'App\\Helpers\\Helper',
      'GoogleMaps' => 'GoogleMaps\\Facade\\GoogleMapsFacade',
      'Stripe' => 'Cartalyst\\Stripe\\Laravel\\Facades\\Stripe',
      'Form' => 'Collective\\Html\\FormFacade',
      'Html' => 'Collective\\Html\\HtmlFacade',
      'PDF' => 'Barryvdh\\DomPDF\\Facade',
      'Captcha' => 'Mews\\Captcha\\Facades\\Captcha',
      'PlivoSms' => 'App\\Helpers\\PlivoSms',
      'Excel' => 'Maatwebsite\\Excel\\Facades\\Excel',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'token',
        'provider' => 'users',
        'hash' => false,
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
      ),
    ),
  ),
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => '',
        'secret' => '',
        'app_id' => '',
        'options' => 
        array (
          'cluster' => 'mt1',
          'useTLS' => true,
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => 'C:\\xampp\\htdocs\\securityagent\\storage\\framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
    ),
    'prefix' => 'be_on_time_cache',
  ),
  'captcha' => 
  array (
    'characters' => 
    array (
      0 => '2',
      1 => '3',
      2 => '4',
      3 => '6',
      4 => '7',
      5 => '8',
      6 => '9',
      7 => 'a',
      8 => 'b',
      9 => 'c',
      10 => 'd',
      11 => 'e',
      12 => 'f',
      13 => 'g',
      14 => 'h',
      15 => 'j',
      16 => 'm',
      17 => 'n',
      18 => 'p',
      19 => 'q',
      20 => 'r',
      21 => 't',
      22 => 'u',
      23 => 'x',
      24 => 'y',
      25 => 'z',
      26 => 'A',
      27 => 'B',
      28 => 'C',
      29 => 'D',
      30 => 'E',
      31 => 'F',
      32 => 'G',
      33 => 'H',
      34 => 'J',
      35 => 'M',
      36 => 'N',
      37 => 'P',
      38 => 'Q',
      39 => 'R',
      40 => 'T',
      41 => 'U',
      42 => 'X',
      43 => 'Y',
      44 => 'Z',
    ),
    'default' => 
    array (
      'length' => 6,
      'width' => 150,
      'height' => 36,
      'quality' => 90,
      'math' => false,
    ),
    'math' => 
    array (
      'length' => 9,
      'width' => 120,
      'height' => 36,
      'quality' => 90,
      'math' => true,
    ),
    'flat' => 
    array (
      'length' => 6,
      'width' => 160,
      'height' => 46,
      'quality' => 90,
      'lines' => 6,
      'bgImage' => false,
      'bgColor' => '#ecf2f4',
      'fontColors' => 
      array (
        0 => '#000000',
      ),
      'contrast' => 10,
    ),
    'mini' => 
    array (
      'length' => 3,
      'width' => 60,
      'height' => 32,
    ),
    'inverse' => 
    array (
      'length' => 5,
      'width' => 120,
      'height' => 36,
      'quality' => 90,
      'sensitive' => true,
      'angle' => 12,
      'sharpen' => 10,
      'blur' => 2,
      'invert' => true,
      'contrast' => -5,
    ),
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'securitydev',
        'prefix' => '',
        'foreign_key_constraints' => true,
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'securitydev',
        'username' => 'root',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => false,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'securitydev',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'schema' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'securitydev',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'predis',
      'options' => 
      array (
        'cluster' => 'predis',
        'prefix' => 'be_on_time_database_',
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => 0,
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => 1,
      ),
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'cloud' => 's3',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\xampp\\htdocs\\securityagent\\storage\\app',
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\xampp\\htdocs\\securityagent\\storage\\app/public',
        'url' => 'http://51.68.139.99/storage',
        'visibility' => 'public',
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
      ),
    ),
  ),
  'googlemaps' => 
  array (
    'key' => 'AIzaSyCqV_RbB8pVKnMhqiIYYuwuz_25qazoILA',
    'ssl_verify_peer' => false,
    'service' => 
    array (
      'geocoding' => 
      array (
        'url' => 'https://maps.googleapis.com/maps/api/geocode/',
        'type' => 'GET',
        'key' => NULL,
        'endpoint' => true,
        'responseDefaultKey' => 'place_id',
        'param' => 
        array (
          'address' => NULL,
          'bounds' => NULL,
          'key' => NULL,
          'region' => NULL,
          'language' => NULL,
          'result_type' => NULL,
          'location_type' => NULL,
          'latlng' => NULL,
          'place_id' => NULL,
          'components' => 
          array (
            'route' => NULL,
            'locality' => NULL,
            'administrative_area' => NULL,
            'postal_code' => NULL,
            'country' => NULL,
          ),
        ),
      ),
      'directions' => 
      array (
        'url' => 'https://maps.googleapis.com/maps/api/directions/',
        'type' => 'GET',
        'key' => NULL,
        'endpoint' => true,
        'responseDefaultKey' => 'geocoded_waypoints',
        'decodePolyline' => true,
        'param' => 
        array (
          'origin' => NULL,
          'destination' => NULL,
          'mode' => NULL,
          'waypoints' => NULL,
          'place_id' => NULL,
          'alternatives' => NULL,
          'avoid' => NULL,
          'language' => NULL,
          'units' => NULL,
          'region' => NULL,
          'departure_time' => NULL,
          'arrival_time' => NULL,
          'transit_mode' => NULL,
          'transit_routing_preference' => NULL,
        ),
      ),
      'distancematrix' => 
      array (
        'url' => 'https://maps.googleapis.com/maps/api/distancematrix/',
        'type' => 'GET',
        'key' => NULL,
        'endpoint' => true,
        'responseDefaultKey' => 'origin_addresses',
        'param' => 
        array (
          'origins' => NULL,
          'destinations' => NULL,
          'key' => NULL,
          'mode' => NULL,
          'language' => NULL,
          'avoid' => NULL,
          'units' => NULL,
          'departure_time' => NULL,
          'arrival_time' => NULL,
          'transit_mode' => NULL,
          'transit_routing_preference' => NULL,
        ),
      ),
      'elevation' => 
      array (
        'url' => 'https://maps.googleapis.com/maps/api/elevation/',
        'type' => 'GET',
        'key' => NULL,
        'endpoint' => true,
        'responseDefaultKey' => 'elevation',
        'param' => 
        array (
          'locations' => NULL,
          'path' => NULL,
          'samples' => NULL,
          'key' => NULL,
        ),
      ),
      'geolocate' => 
      array (
        'url' => 'https://www.googleapis.com/geolocation/v1/geolocate?',
        'type' => 'POST',
        'key' => NULL,
        'endpoint' => false,
        'responseDefaultKey' => 'location',
        'param' => 
        array (
          'homeMobileCountryCode' => NULL,
          'homeMobileNetworkCode' => NULL,
          'radioType' => NULL,
          'carrier' => NULL,
          'considerIp' => NULL,
          'cellTowers' => 
          array (
            'cellId' => NULL,
            'locationAreaCode' => NULL,
            'mobileCountryCode' => NULL,
            'mobileNetworkCode' => NULL,
            'age' => NULL,
            'signalStrength' => NULL,
            'timingAdvance' => NULL,
          ),
          'wifiAccessPoints' => 
          array (
            'macAddress' => NULL,
            'signalStrength' => NULL,
            'age' => NULL,
            'channel' => NULL,
            'signalToNoiseRatio' => NULL,
          ),
        ),
      ),
      'snapToRoads' => 
      array (
        'url' => 'https://roads.googleapis.com/v1/snapToRoads?',
        'type' => 'GET',
        'key' => NULL,
        'endpoint' => false,
        'responseDefaultKey' => 'snappedPoints',
        'param' => 
        array (
          'locations' => NULL,
          'path' => NULL,
          'samples' => NULL,
          'key' => NULL,
        ),
      ),
      'speedLimits' => 
      array (
        'url' => 'https://roads.googleapis.com/v1/speedLimits?',
        'type' => 'GET',
        'key' => NULL,
        'endpoint' => false,
        'responseDefaultKey' => 'speedLimits',
        'param' => 
        array (
          'path' => NULL,
          'placeId' => NULL,
          'units' => NULL,
          'key' => NULL,
        ),
      ),
      'timezone' => 
      array (
        'url' => 'https://maps.googleapis.com/maps/api/timezone/',
        'type' => 'GET',
        'key' => NULL,
        'endpoint' => true,
        'responseDefaultKey' => 'dstOffset',
        'param' => 
        array (
          'location' => NULL,
          'timestamp' => NULL,
          'key' => NULL,
          'language' => NULL,
        ),
      ),
      'nearbysearch' => 
      array (
        'url' => 'https://maps.googleapis.com/maps/api/place/nearbysearch/',
        'type' => 'GET',
        'key' => NULL,
        'endpoint' => true,
        'responseDefaultKey' => 'results',
        'param' => 
        array (
          'key' => NULL,
          'location' => NULL,
          'radius' => NULL,
          'keyword' => NULL,
          'language' => NULL,
          'minprice' => NULL,
          'maxprice' => NULL,
          'name' => NULL,
          'opennow' => NULL,
          'rankby' => NULL,
          'type' => NULL,
          'pagetoken' => NULL,
          'zagatselected' => NULL,
        ),
      ),
      'textsearch' => 
      array (
        'url' => 'https://maps.googleapis.com/maps/api/place/textsearch/',
        'type' => 'GET',
        'key' => NULL,
        'endpoint' => true,
        'responseDefaultKey' => 'results',
        'param' => 
        array (
          'key' => NULL,
          'query' => NULL,
          'location' => NULL,
          'radius' => NULL,
          'language' => NULL,
          'minprice' => NULL,
          'maxprice' => NULL,
          'opennow' => NULL,
          'type' => NULL,
          'pagetoken' => NULL,
          'zagatselected' => NULL,
        ),
      ),
      'radarsearch' => 
      array (
        'url' => 'https://maps.googleapis.com/maps/api/place/radarsearch/',
        'type' => 'GET',
        'key' => NULL,
        'endpoint' => true,
        'responseDefaultKey' => 'geometry',
        'param' => 
        array (
          'key' => NULL,
          'radius' => NULL,
          'location' => NULL,
          'keyword' => NULL,
          'minprice' => NULL,
          'maxprice' => NULL,
          'opennow' => NULL,
          'name' => NULL,
          'type' => NULL,
          'zagatselected' => NULL,
        ),
      ),
      'placedetails' => 
      array (
        'url' => 'https://maps.googleapis.com/maps/api/place/details/',
        'type' => 'GET',
        'key' => NULL,
        'endpoint' => true,
        'responseDefaultKey' => 'result',
        'param' => 
        array (
          'key' => NULL,
          'placeid' => NULL,
          'extensions' => NULL,
          'language' => NULL,
        ),
      ),
      'placeadd' => 
      array (
        'url' => 'https://maps.googleapis.com/maps/api/place/add/',
        'type' => 'POST',
        'key' => NULL,
        'endpoint' => true,
        'responseDefaultKey' => 'place_id',
        'param' => 
        array (
          'key' => NULL,
          'accuracy' => NULL,
          'address' => NULL,
          'language' => NULL,
          'location' => NULL,
          'name' => NULL,
          'phone_number' => NULL,
          'types' => NULL,
          'type' => NULL,
          'website' => NULL,
        ),
      ),
      'placedelete' => 
      array (
        'url' => 'https://maps.googleapis.com/maps/api/place/delete/',
        'type' => 'POST',
        'key' => NULL,
        'endpoint' => true,
        'responseDefaultKey' => 'status',
        'param' => 
        array (
          'key' => NULL,
          'place_id' => NULL,
        ),
      ),
      'placephoto' => 
      array (
        'url' => 'https://maps.googleapis.com/maps/api/place/photo?',
        'type' => 'GET',
        'key' => NULL,
        'endpoint' => false,
        'responseDefaultKey' => 'image',
        'param' => 
        array (
          'key' => NULL,
          'photoreference' => NULL,
          'maxheight' => NULL,
          'maxwidth' => NULL,
        ),
      ),
      'placeautocomplete' => 
      array (
        'url' => 'https://maps.googleapis.com/maps/api/place/autocomplete/',
        'type' => 'GET',
        'key' => NULL,
        'endpoint' => true,
        'responseDefaultKey' => 'predictions',
        'param' => 
        array (
          'key' => NULL,
          'input' => NULL,
          'offset' => NULL,
          'location' => NULL,
          'radius' => NULL,
          'language' => NULL,
          'types' => NULL,
          'type' => NULL,
          'components' => NULL,
        ),
      ),
      'placequeryautocomplete' => 
      array (
        'url' => 'https://maps.googleapis.com/maps/api/place/queryautocomplete/',
        'type' => 'GET',
        'key' => NULL,
        'endpoint' => true,
        'responseDefaultKey' => 'predictions',
        'param' => 
        array (
          'key' => NULL,
          'input' => NULL,
          'offset' => NULL,
          'location' => NULL,
          'radius' => NULL,
          'language' => NULL,
        ),
      ),
    ),
    'endpoint' => 
    array (
      'xml' => 'xml?',
      'json' => 'json?',
    ),
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => 10,
    ),
    'argon' => 
    array (
      'memory' => 1024,
      'threads' => 2,
      'time' => 2,
    ),
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'daily',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => 'C:\\xampp\\htdocs\\securityagent\\storage\\logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => 'C:\\xampp\\htdocs\\securityagent\\storage\\logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'critical',
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
    ),
  ),
  'mail' => 
  array (
    'driver' => 'smtp',
    'host' => 'SSL0.OVH.NET',
    'port' => '587',
    'from' => 
    array (
      'address' => 'contact@ontimebe.com',
      'name' => 'Be On Time',
    ),
    'encryption' => 'tls',
    'username' => 'contact@ontimebe.com',
    'password' => 'Contact@123',
    'sendmail' => '/usr/sbin/sendmail -bs',
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => 'C:\\xampp\\htdocs\\securityagent\\resources\\views/vendor/mail',
      ),
    ),
    'log_channel' => NULL,
    'stream' => 
    array (
      'ssl' => 
      array (
        'allow_self_signed' => true,
        'verify_peer' => false,
        'verify_peer_name' => false,
      ),
    ),
  ),
  'queue' => 
  array (
    'default' => 'sync',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'your-queue-name',
        'region' => 'us-east-1',
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
      ),
    ),
    'failed' => 
    array (
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => NULL,
      'secret' => NULL,
      'endpoint' => 'api.mailgun.net',
    ),
    'postmark' => 
    array (
      'token' => NULL,
    ),
    'ses' => 
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
    'sparkpost' => 
    array (
      'secret' => NULL,
    ),
    'stripe' => 
    array (
      'secret' => 'sk_test_rWpNtaIWNpvINOkFyRhdkrMd00LvPs3eUK',
      'currency' => 'EUR',
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => '120',
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => 'C:\\xampp\\htdocs\\securityagent\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'be_on_time_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => false,
    'http_only' => true,
    'same_site' => NULL,
  ),
  'translation' => 
  array (
    'driver' => 'file',
    'route_group_config' => 
    array (
      'middleware' => 'web',
    ),
    'translation_methods' => 
    array (
      0 => 'trans',
      1 => '__',
    ),
    'scan_paths' => 
    array (
      0 => 'C:\\xampp\\htdocs\\securityagent\\app',
      1 => 'C:\\xampp\\htdocs\\securityagent\\resources',
    ),
    'ui_url' => 'languages',
    'database' => 
    array (
      'connection' => '',
      'languages_table' => 'languages',
      'translations_table' => 'translations',
    ),
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => 'C:\\xampp\\htdocs\\securityagent\\resources\\views',
    ),
    'compiled' => 'C:\\xampp\\htdocs\\securityagent\\storage\\framework\\views',
  ),
  'dompdf' => 
  array (
    'show_warnings' => false,
    'orientation' => 'portrait',
    'defines' => 
    array (
      'font_dir' => 'C:\\xampp\\htdocs\\securityagent\\storage\\fonts/',
      'font_cache' => 'C:\\xampp\\htdocs\\securityagent\\storage\\fonts/',
      'temp_dir' => 'C:\\Users\\User\\AppData\\Local\\Temp',
      'chroot' => 'C:\\xampp\\htdocs\\securityagent',
      'enable_font_subsetting' => false,
      'pdf_backend' => 'CPDF',
      'default_media_type' => 'screen',
      'default_paper_size' => 'a4',
      'default_font' => 'serif',
      'dpi' => 96,
      'enable_php' => false,
      'enable_javascript' => true,
      'enable_remote' => true,
      'font_height_ratio' => 1.1,
      'enable_html5_parser' => false,
    ),
  ),
  'debug-server' => 
  array (
    'host' => 'tcp://127.0.0.1:9912',
  ),
  'image' => 
  array (
    'driver' => 'gd',
  ),
  'trustedproxy' => 
  array (
    'proxies' => NULL,
    'headers' => 30,
  ),
  'excel' => 
  array (
    'cache' => 
    array (
      'enable' => true,
      'driver' => 'memory',
      'settings' => 
      array (
        'memoryCacheSize' => '32MB',
        'cacheTime' => 600,
      ),
      'memcache' => 
      array (
        'host' => 'localhost',
        'port' => 11211,
      ),
      'dir' => 'C:\\xampp\\htdocs\\securityagent\\storage\\cache',
    ),
    'properties' => 
    array (
      'creator' => 'Maatwebsite',
      'lastModifiedBy' => 'Maatwebsite',
      'title' => 'Spreadsheet',
      'description' => 'Default spreadsheet export',
      'subject' => 'Spreadsheet export',
      'keywords' => 'maatwebsite, excel, export',
      'category' => 'Excel',
      'manager' => 'Maatwebsite',
      'company' => 'Maatwebsite',
    ),
    'sheets' => 
    array (
      'pageSetup' => 
      array (
        'orientation' => 'portrait',
        'paperSize' => '9',
        'scale' => '100',
        'fitToPage' => false,
        'fitToHeight' => true,
        'fitToWidth' => true,
        'columnsToRepeatAtLeft' => 
        array (
          0 => '',
          1 => '',
        ),
        'rowsToRepeatAtTop' => 
        array (
          0 => 0,
          1 => 0,
        ),
        'horizontalCentered' => false,
        'verticalCentered' => false,
        'printArea' => NULL,
        'firstPageNumber' => NULL,
      ),
    ),
    'creator' => 'Maatwebsite',
    'csv' => 
    array (
      'delimiter' => ',',
      'enclosure' => '"',
      'line_ending' => '
',
      'use_bom' => false,
    ),
    'export' => 
    array (
      'autosize' => true,
      'autosize-method' => 'approx',
      'generate_heading_by_indices' => true,
      'merged_cell_alignment' => 'left',
      'calculate' => false,
      'includeCharts' => false,
      'sheets' => 
      array (
        'page_margin' => false,
        'nullValue' => NULL,
        'startCell' => 'A1',
        'strictNullComparison' => false,
      ),
      'store' => 
      array (
        'path' => 'C:\\xampp\\htdocs\\securityagent\\storage\\exports',
        'returnInfo' => false,
      ),
      'pdf' => 
      array (
        'driver' => 'DomPDF',
        'drivers' => 
        array (
          'DomPDF' => 
          array (
            'path' => 'C:\\xampp\\htdocs\\securityagent\\vendor/dompdf/dompdf/',
          ),
          'tcPDF' => 
          array (
            'path' => 'C:\\xampp\\htdocs\\securityagent\\vendor/tecnick.com/tcpdf/',
          ),
          'mPDF' => 
          array (
            'path' => 'C:\\xampp\\htdocs\\securityagent\\vendor/mpdf/mpdf/',
          ),
        ),
      ),
    ),
    'filters' => 
    array (
      'registered' => 
      array (
        'chunk' => 'Maatwebsite\\Excel\\Filters\\ChunkReadFilter',
      ),
      'enabled' => 
      array (
      ),
    ),
    'import' => 
    array (
      'heading' => 'slugged',
      'startRow' => 1,
      'separator' => '_',
      'slug_whitelist' => '._',
      'includeCharts' => false,
      'to_ascii' => true,
      'encoding' => 
      array (
        'input' => 'UTF-8',
        'output' => 'UTF-8',
      ),
      'calculate' => true,
      'ignoreEmpty' => false,
      'force_sheets_collection' => false,
      'dates' => 
      array (
        'enabled' => true,
        'format' => false,
        'columns' => 
        array (
        ),
      ),
      'sheets' => 
      array (
        'test' => 
        array (
          'firstname' => 'A2',
        ),
      ),
    ),
    'views' => 
    array (
      'styles' => 
      array (
        'th' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 12,
          ),
        ),
        'strong' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 12,
          ),
        ),
        'b' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 12,
          ),
        ),
        'i' => 
        array (
          'font' => 
          array (
            'italic' => true,
            'size' => 12,
          ),
        ),
        'h1' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 24,
          ),
        ),
        'h2' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 18,
          ),
        ),
        'h3' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 13.5,
          ),
        ),
        'h4' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 12,
          ),
        ),
        'h5' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 10,
          ),
        ),
        'h6' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 7.5,
          ),
        ),
        'a' => 
        array (
          'font' => 
          array (
            'underline' => true,
            'color' => 
            array (
              'argb' => 'FF0000FF',
            ),
          ),
        ),
        'hr' => 
        array (
          'borders' => 
          array (
            'bottom' => 
            array (
              'style' => 'thin',
              'color' => 
              array (
                0 => 'FF000000',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
);
