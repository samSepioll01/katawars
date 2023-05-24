<?php

namespace App\CustomClasses;

use App\Jobs\ReportAbuseJob;
use Illuminate\Support\Str;
use ParseError;

class SecurityFilter
{

    /**
     * Override method to declare the S3 Facade.
     */
    protected static function getFacadeAccessor()
    {
        return 'SecurityFilter';
    }

    /**
     * Parse malicious patterns in the code.
     *
     * @param string $code
     * @return true|ParseError
     */
    public static function parser(string $code)
    {
        $filters = array_merge(
            self::getFunctionsHexStrings(),
            self::getBackdoorPatterns(),
            self::getBase64StringSamples(),
            self::getRequestObjects(),
            self::getREPatterns(),
            self::getBuiltinShell(),
            self::getForbiddenSymbols(),
        );

        $code = Str::of($code);

        foreach($filters as $filter) {

            if (Str::contains($code, $filter) || Str::contains($code, strrev($filter))) {
                ReportAbuseJob::dispatch($code, auth()->user())
                    ->onQueue('sendMailQueue');
                throw new ParseError;
            }
        }

        return true;
    }

    /**
     * Get functions escaped as hexadecimal strings.
     */
    protected static function getFunctionsHexStrings(): array
    {
        return [
            '7068705f756e616d65',
            '70687076657273696f6e',
            '6368646972',
            '676574637764',
            '707265675f73706c6974',
            '636f7079',
            '66696c655f6765745f636f6e74656e7473',
            '6261736536345f6465636f6465',
            '69735f646972',
            '6f625f656e645f636c65616e28293b',
            '756e6c696e6b',
            '6d6b646972',
            '63686d6f64',
            '7363616e646972',
            '7374725f7265706c616365',
            '68746d6c7370656369616c6368617273',
            '7661725f64756d70',
            '666f70656e',
            '667772697465',
            '66636c6f7365',
            '64617465',
            '66696c656d74696d65',
            '737562737472',
            '737072696e7466',
            '66696c657065726d73',
            '746f756368',
            '66696c655f657869737473',
            '72656e616d65',
            '69735f6172726179',
            '69735f6f626a656374',
            '737472706f73',
            '69735f7772697461626c65',
            '69735f7265616461626c65',
            '737472746f74696d65',
            '66696c6573697a65',
            '726d646972',
            '6f625f6765745f636c65616e',
            '7265616466696c65',
            '617373657274',
        ];
    }

    protected static function getBackdoorPatterns(): array
    {
        return [
            '\145\166\141\154\050\142\141\163\145\066\064\137\144\145\143\157\144\145\050',
            '@array_diff_ukey(@array((string)$_REQUEST["password"]=>1), @array((string)stripslashes($_REQUEST["re_password"])=>2), $_REQUEST["login"]);',
            '<?php ${${eval($_POST[ice])}};?>',
            '<?$x=$_GET;($x[p]==_?$x[f]($x[c]):y);',
            '<?$x=explode("~,base64_decode(substr(getallheaders()["x"],1)));@$x[0]($x[1]);',
            '<?php extract($_REQUEST); @die($ctime($atime));',
        ];
    }

    protected static function getBase64StringSamples(): array
    {
        return [
            'c2hlbG', // shell
            'NoZWxs',
            'zaGVsb',
            'PD9waH', // <?php
            '8P3Boc',
            'c3Rhd', // stat
            'N0YX',
            'zdGF0',
            'Y29we', // copy
            'NvcH',
            'jb3B5',
            'Y2hy', // chr
            'c3lzdGVt', // system
            'N5c3Rlb',
            'zeXN0ZW',
            'cmVwbGFjZ', // replace
            'JlcGxhY2',
            'yZXBsYWNl',
            'c3RyX', // "str_"
            'N0cl',
            'zdHJf',
            'ZXhlYy', // exec
            'V4ZWMo',
            'leGVjK',
            'ZWNob', // echo
            'VjaG',
            'lY2hv',
            'ZnVuY3Rpb2', // function
            'Z1bmN0aW9u',
            'mdW5jdGlvb',
            'aW5jbHVkZ', // include
            'luY2x1ZG',
            'pbmNsdWRl',
            'cmVxdWlyZ', // require
            'JlcXVpcm',
            'yZXF1aXJl',
            'YmFzZTY0', // base4
            'Jhc2U2N',
            'iYXNlNj',
            'ZXZhb', // eval
            'V2YW',
            'ldmFs',
            'SFRUUF9VU0VSX0FHRU5U', // HTTP_USER_AGENT
            'hUVFBfVVNFUl9BR0VOV',
            'IVFRQX1VTRVJfQUdFTl',
            'Z3ppbmZsYXRl', // gzinflate
            'd6aW5mbGF0Z',
            'nemluZmxhdG',
            'b3Blb', // open
            '9wZW',
            'vcGVu',
            'Y2xvc2', // close
            'Nsb3Nl',
            'jbG9zZ',
            'YXJyYXlf', // array_
            'FycmF5X',
            'hcnJheV',
            'Y3NsYXNoZX', // cslashes
            'NzbGFzaGVz',
            'jc2xhc2hlc',
            'ZXh0cmFjd', // extract
            'V4dHJhY3',
            'leHRyYWN0',
            'JF9HRV', // $_GET
            'RfR0VU',
            'kX0dFV',
            'JF9QT1NU', // $_POST
            'RfUE9TV',
            'kX1BPU1',
            'JF9DT09LSU', // $_COOKIE
            'RfQ09PS0lF',
            'kX0NPT0tJR',
            'JF9SRVFVRVNU', // $_REQUEST
            'RfUkVRVUVTV',
            'kX1JFUVVFU1',
            'R0xPQkFMU', // GLOBALS
            'dMT0JBTF',
            'HTE9CQUxT',
            'c2l6ZW9m', // sizeof
            'NpemVvZ',
            'zaXplb2',
            'cHJpbnRm', // printf
            'ByaW50Z',
            'wcmludG',
            'ZGVmaW5l', // define
            'RlZmluZ',
            'kZWZpbm',
        ];
    }

    /**
     * Get the main requests objects attacked.
     */
    protected static function getRequestObjects(): array
    {
        return [
            '$_GET',
            '$get',
            '$GET',
            '$_POST',
            '$post',
            '$POST',
            '$GLOBALS',
            '$_COOKIE',
            '$_SESSION',
            '$_FILES',
            '$_REQUEST',
            '$_ENV',
            '$_SERVER',
        ];
    }

    /**
     * Get the malicious regular expresion patterns.
     */
    protected static function getREPatterns(): array
    {
        return [
            'eval\/\*[a-z0-9]+\*\/', // eval /* */
            'eval\([a-z0-9]{4,}\(\$[a-z0-9]{4,}, \$[0-9a-z]{4,}\)\);',
            '(chr\(\d+\^\d+\)\.){4,}', // chr(101).chr(118).chr(97)
            '(\$\_[a-z0-9]{2,}\(\d+\)\.){4,}', // $_uU(101).$_uU(118).$_uU(97)
            '(\$[a-z0-9]{3,}\[\d+\]\.){4,}', // $uUx[101].$uUx[118].$uUx[97]
            'chr\(\d+\)\.""\.""\.""\.""\.""',
            '\$GLOBALS\[\$GLOBALS["[a-z0-9]{4,}"\]\[\d+\]\.\$GLOBALS\["[a-z-0-9]{4,}"\]\[\d+\].',
            '\$GLOBALS\["[a-z0-9]{5,}"\] = \$[a-z]+\d+\[\d+\]\.\$[a-z]+\d+\[\d+\]\.\$[a-z]+\d+\[\d+\]\.\$[a-z]+\d+\[\d+\]\.',
            '{\s*eval\s*\(\s*\$,',
            'Googlebot[""]{0,1}\s*\)\){echo\s+file_get_contents',
            'if\s*\(\s*mail\s*\(\s*\$mails\[\$i\]\s*,\s*\$tema\s*,\s*base64_encode\s*\(\s*\$text',
            'echo\s+file_get_contents\s*\(\s*base64_url_decode\s*\(\s*@*\$_(GET|POST|SERVER|COOKIE|REQUEST)',
            'chr\s*\(\s*101\s*\)\s*\.\s*chr\s*\(\s*118\s*\)\s*\.\s*chr\s*\(\s*97\s*\)\s*\.\s*chr\s*\(\s*108\s*\)',
            '(\$OOO_O_000_\{\d+\}.){3,}',
            '^.*<\?php.{1100,}\?>.*$',
            '\/\*[a-z0-9]{5}\*\/',
            '%\(\d+\-\d+\+\d+\)==\(\-\d+\+\d+\+\d+\)',
            '\(\$[a-zA-Z0-9]+%\d==\(\d+\-\d+\+\d+\)',
            'eval\(\$[a-z0-9_]+\(\$_POST',
            '("[a-z0-9]+"\.chr\(\d+\)\.){3,}',
            '(\^\s*\$\w+\[\$\w+\s*%\s*strlen\(\$\w+\)\]\s*){2,}',
            '(\$[A-Z]+\{\d+\}\.){3,}',
            '\(count\(\$p\)==\d+&&in_array\(gettype\(\$p\)\.count\(\$p\),\$p\)\)',
            "@header\(\w{3,5}::\w{1,2}\('_\w{1,3}', '_' \. '\w{1,3}' . '\w{1,3}'\)\);",
            '@\$[a-z]{1}\[\d+\]\(\$[a-z]{1}\[\d+\]\);',
            '\$[a-z]11 \^ [a-z]8\(\$[a-z]6, \$[a-z]14, \$[a-z]6\[13\]\(\$[a-z]11\)\)\)\);',
            "eval\([A-Za-z0-9]{5,}\(\) \. '",
            'eval\([A-Za-z0-9]{5,}\(\"[A-Z0-9]{16,}',
            '\$[a-zA-Z0-9]{6,}\("\x78\x9C\xAD\x90\x41\x0E',
            'return @\$[a-z]{2}\d+\[\d+\]\(\$[a-z]{2}\d+\[\d+\],',
            '[a-z]{1}\([a-z]{1}\(\$[a-z]{2}\."\/\.htaccess"\)',
        ];
    }

    protected static function getBuiltinShell(): array
    {
        return [
            'rm -rf',
            'move_uploaded_file',
            'session_start',
            'session_destroy',
            'file_get_contents',
            'include',
            'include_once',
            'require',
            'global',
            '/etc/passwd',
            '/tmp',
            '/etc/shadow',
            'psql',
            'mysql',
            'exec',
            'eval',
            'call_user_funct',
            'file_get_upload',
            'preg_match',
            'preg_replace',
            'preg_split',
            'preg_grep',
            'preg_filter',
            'preg_quote',
            'preg_last_error',
            'system',
            'md5',
            'json_encode',
            'json_decode',
            'fwrite',
            'HTTP_COOKIE',
            'getenv',
            'env',
            'base64_encode',
            'base64_decode',
            'wget',
            'curl',
        ];
    }

    protected static function getForbiddenSymbols(): array
    {
        return [
            '@',
            '^',
            '#',
            '~',
            '>1',
            '&>2'
        ];
    }
}
