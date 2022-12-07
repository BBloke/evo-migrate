<?php
// bbloke/evo-migrate v2
// Trying to utilise ajax

$count = 0;
$checkUsername = 0;
$checkEmail = 0;

$_REQUEST['action'] ??= '';

$tempWebGroupAccess = 'tempwebgroup_access';

$lang_array = ['ukrainian' => 'uk',
    'svenska' => 'sv', 'svenska-utf8' => 'sv', 'spanish' => 'es', 'spanish-utf8' => 'es', 'simple_chinese-gb2312' => 'zh', 'simple_chinese-gb2312-utf8' => 'zh',
    'russian' => 'ru', 'russian-UTF8' => 'ru', 'portuguese' => 'pt', 'portuguese-br' => 'pt-br', 'portuguese-br-utf8' => 'pt-br',
    'polish' => 'pl', 'polish-utf8' => 'pl', 'persian' => 'fa', 'norsk' => 'no', 'nederlands' => 'nl', 'nederlands-utf8' => 'nl',
    'japanese-utf8' => 'ja', 'italian' => 'it', 'hebrew' => 'he', 'german' => 'de', 'francais' => 'fr', 'francais-utf8' => 'fr',
    'finnish' => 'fi', 'english' => 'en', 'english-british' => 'en', 'danish' => 'da', 'czech' => 'cs', 'chinese' => 'zh', 'bulgarian' => 'bz'];
chdir('../');
$base_dir = getcwd();

include_once $modx->getConfig('base_path') . 'assets/modules/evomigrate/evomigrate.class.inc.php';

echo evoMigrate::initiate();

die("Got to the end of the file");


