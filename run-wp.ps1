param(
    [Parameter(ValueFromRemainingArguments = $true)]
    [string[]]$WpArgs
)

$php = "C:\Users\JMATA\AppData\Local\Programs\Local\resources\extraResources\lightning-services\php-8.2.29+0\bin\win64\php.exe"
$phpIni = "$env:APPDATA\Local\run\uHjdKG5fB\conf\php\php.ini"
$wpCli = "C:\Users\JMATA\AppData\Local\Programs\Local\resources\extraResources\bin\wp-cli\wp-cli.phar"
$sitePath = "C:\Users\JMATA\Local Sites\rama-caida\app\public"

& $php -c $phpIni $wpCli --path=$sitePath @WpArgs
