<?php

namespace MailSo\Base;

/**
 * @category MailSo
 * @package Base
 */
class Utils
{
	/**
	 * @var array
	 */
	public static $SuppostedCharsets = array(
		'iso-8859-1', 'iso-8859-2', 'iso-8859-3', 'iso-8859-4', 'iso-8859-5', 'iso-8859-6',
		'iso-8859-7', 'iso-8859-8', 'iso-8859-9', 'iso-8859-10', 'iso-8859-11', 'iso-8859-12',
		'iso-8859-13', 'iso-8859-14', 'iso-8859-15', 'iso-8859-16',
		'koi8-r', 'koi8-u', 'koi8-ru',
		'cp1250', 'cp1251', 'cp1252', 'cp1253', 'cp1254', 'cp1257', 'cp949', 'cp1133',
		'cp850', 'cp866', 'cp1255', 'cp1256', 'cp862', 'cp874', 'cp932', 'cp950', 'cp1258',
		'windows-1250', 'windows-1251', 'windows-1252', 'windows-1253', 'windows-1254', 'windows-1255',
		'windows-1256', 'windows-1257', 'windows-1258', 'windows-874',
		'macroman', 'maccentraleurope', 'maciceland', 'maccroatian', 'macromania', 'maccyrillic',
		'macukraine', 'macgreek', 'macturkish', 'macintosh', 'machebrew', 'macarabic',
		'euc-jp', 'shift_jis', 'iso-2022-jp', 'iso-2022-jp-2', 'iso-2022-jp-1',
		'euc-cn', 'gb2312', 'hz', 'gbk', 'gb18030', 'euc-tw', 'big5', 'big5-hkscs',
		'iso-2022-cn', 'iso-2022-cn-ext', 'euc-kr', 'iso-2022-kr', 'johab',
		'armscii-8', 'georgian-academy', 'georgian-ps', 'koi8-t',
		'tis-620', 'macthai', 'mulelao-1',
		'viscii', 'tcvn', 'hp-roman8', 'nextstep',
		'utf-8', 'ucs-2', 'ucs-2be', 'ucs-2le', 'ucs-4', 'ucs-4be', 'ucs-4le',
		'utf-16', 'utf-16be', 'utf-16le', 'utf-32', 'utf-32be', 'utf-32le', 'utf-7',
		'c99', 'java', 'ucs-2-internal', 'ucs-4-internal');

	/**
	 * @access private
	 */
	private function __construct()
	{
	}

	/**
	 * @param string $sEncoding
	 *
	 * @return string
	 */
	private static function normalizeCharset($sEncoding)
	{
		$sEncoding = \strtolower($sEncoding);
		switch ($sEncoding)
		{
			case 'ansi':
			case 'ansii':
			case 'us-ansi':
			case 'us-ansii':
				$sEncoding = \MailSo\Base\Enumerations\Charset::ISO_8859_1;
				break;
			case 'unicode-1-1-utf-7':
				$sEncoding = \MailSo\Base\Enumerations\Charset::UTF_7;
				break;
			case 'utf8':
			case 'utf-8':
				$sEncoding = \MailSo\Base\Enumerations\Charset::UTF_8;
				break;
			case 'utf7imap':
			case 'utf-7imap':
			case 'utf7-imap':
			case 'utf-7-imap':
				$sEncoding = \MailSo\Base\Enumerations\Charset::UTF_7_IMAP;
				break;
			case 'ks-c-5601-1987':
			case 'ks_c_5601-1987':
			case 'ks_c_5601_1987':
				$sEncoding = 'euc-kr';
				break;
			case 'x-gbk':
				$sEncoding = 'gb2312';
				break;
			case 'iso-8859-i':
			case 'iso-8859-8-i':
				$sEncoding = \MailSo\Base\Enumerations\Charset::ISO_8859_8;
				break;
		}

		return $sEncoding;
	}

	/**
	 * @return bool
	 */
	public static function IsIconvSupported()
	{
		return \function_exists('iconv');
	}

	/**
	 * @return bool
	 */
	public static function IsMbStringSupported()
	{
		return \function_exists('mb_convert_encoding');
	}

	/**
	 * @param string $sCharset
	 *
	 * @return bool
	 */
	public static function ValidateCharsetName($sCharset)
	{
		$sCharset = \strtolower(\MailSo\Base\Utils::normalizeCharset($sCharset));
		return 0 < \strlen($sCharset) && (\in_array($sCharset, array(\MailSo\Base\Enumerations\Charset::UTF_7_IMAP)) ||
			\in_array($sCharset, \MailSo\Base\Utils::$SuppostedCharsets));
	}

	/**
	 * @param string $sInputString
	 * @param string $sInputFromEncoding
	 * @param string $sInputToEncoding
	 *
	 * @return string
	 */
	public static function ConvertEncoding($sInputString, $sInputFromEncoding, $sInputToEncoding)
	{
		$sResult = $sInputString;

		$sFromEncoding = \MailSo\Base\Utils::normalizeCharset($sInputFromEncoding);
		$sToEncoding = \MailSo\Base\Utils::normalizeCharset($sInputToEncoding);

		if ('' === \trim($sResult) || ($sFromEncoding === $sToEncoding && \MailSo\Base\Enumerations\Charset::UTF_8 !== $sFromEncoding))
		{
			return $sResult;
		}

		$bUnknown = false;
		switch (true)
		{
			default:
				$bUnknown = true;
				break;

			case ($sFromEncoding === \MailSo\Base\Enumerations\Charset::ISO_8859_1 &&
					$sToEncoding === \MailSo\Base\Enumerations\Charset::UTF_8 &&
					\function_exists('utf8_encode')):

				$sResult = \utf8_encode($sResult);
				break;

			case ($sFromEncoding === \MailSo\Base\Enumerations\Charset::UTF_8 &&
					$sToEncoding === \MailSo\Base\Enumerations\Charset::ISO_8859_1 &&
					\function_exists('utf8_decode')):

				$sResult = \utf8_decode($sResult);
				break;

			case ($sFromEncoding === \MailSo\Base\Enumerations\Charset::UTF_7_IMAP &&
					$sToEncoding === \MailSo\Base\Enumerations\Charset::UTF_8):

				$sResult = \MailSo\Base\Utils::Utf7ModifiedToUtf8($sResult);
				if (false === $sResult)
				{
					$sResult = $sInputString;
				}
				break;

			case ($sFromEncoding === \MailSo\Base\Enumerations\Charset::UTF_8 &&
					$sToEncoding === \MailSo\Base\Enumerations\Charset::UTF_7_IMAP):

				$sResult = \MailSo\Base\Utils::Utf8ToUtf7Modified($sResult);
				if (false === $sResult)
				{
					$sResult = $sInputString;
				}
				break;

			case ($sFromEncoding === \MailSo\Base\Enumerations\Charset::UTF_7_IMAP):

				$sResult = \MailSo\Base\Utils::ConvertEncoding(\MailSo\Base\Utils::ModifiedToPlainUtf7($sResult),
					\MailSo\Base\Enumerations\Charset::UTF_7, $sToEncoding);
				break;

			case (\in_array(\strtolower($sFromEncoding), \MailSo\Base\Utils::$SuppostedCharsets)):

				if (\MailSo\Base\Utils::IsIconvSupported())
				{
					$sResult = @\iconv($sFromEncoding, $sToEncoding.'//IGNORE', $sResult);
				}
				else if (\MailSo\Base\Utils::IsMbStringSupported())
				{
					$sResult = @\mb_convert_encoding($sResult, $sToEncoding, $sFromEncoding);
				}

				$sResult = (false !== $sResult) ? $sResult : $sInputString;
				break;
		}

		if ($bUnknown && \MailSo\Base\Utils::IsMbStringSupported())
		{
			$sResult = @\mb_convert_encoding($sResult, $sToEncoding);
		}

		return $sResult;
	}

	/**
	 * @param string $sValue
	 *
	 * @return bool
	 */
	public static function IsAscii($sValue)
	{
		return !\preg_match('/[^\x09\x10\x13\x0A\x0D\x20-\x7E]/', $sValue);
	}

	/**
	 * @param int $iSize
	 * @param int $iRound
	 *
	 * @return string
	 */
	public static function FormatFileSize($iSize, $iRound = 0)
	{
		$aSizes = array('B', 'KB', 'MB');
		for ($iIndex = 0; $iSize > 1024 && isset($aSizes[$iIndex + 1]); $iIndex++)
		{
			$iSize /= 1024;
		}
		return \round($iSize, $iRound).$aSizes[$iIndex];
	}

	/**
	 * @param string $sEncodedValue
	 * @param string $sEncodeingType
	 *
	 * @return string
	 */
	public static function DecodeEncodingValue($sEncodedValue, $sEncodeingType)
	{
		$sResult = $sEncodedValue;
		switch (\strtolower($sEncodeingType))
		{
			case 'q':
			case 'quoted_printable':
			case 'quoted-printable':
				$sResult = \quoted_printable_decode($sResult);
				break;
			case 'b':
			case 'base64':
				$sResult = \MailSo\Base\Utils::Base64Decode($sResult);
				break;
		}
		return $sResult;
	}

	/**
	 * @param string $sEncodedValue
	 * @param string $sIncomingCharset = ''
	 * @param string $sForcedIncomingCharset = ''
	 *
	 * @return string
	 */
	public static function DecodeHeaderValue($sEncodedValue, $sIncomingCharset = '', $sForcedIncomingCharset = '')
	{
		$sValue = $sEncodedValue;
		if (0 < \strlen($sIncomingCharset))
		{
			$sValue = \MailSo\Base\Utils::ConvertEncoding($sValue, $sIncomingCharset,
				\MailSo\Base\Enumerations\Charset::UTF_8);
		}

		$sValue = \preg_replace('/\?=[\n\r\t\s]{1,5}=\?/m', '?==?', $sValue);
		$sValue = \preg_replace('/[\r\n\t]+/m', ' ', $sValue);

		$aEncodeArray = array('');
		$aMatch = array();
		\preg_match_all('/=\?[^\?]+\?[q|b|Q|B]\?[^\?]*(\?=)/', $sValue, $aMatch);

		if (isset($aMatch[0]) && \is_array($aMatch[0]))
		{
			for ($iIndex = 0, $iLen = \count($aMatch[0]); $iIndex < $iLen; $iIndex++)
			{
				if (isset($aMatch[0][$iIndex]))
				{
					$iPos = @\strpos($aMatch[0][$iIndex], '*');
					if (false !== $iPos)
					{
						$aMatch[0][$iIndex][0] = \substr($aMatch[0][$iIndex][0], 0, $iPos);
					}
				}
			}

			$aEncodeArray = $aMatch[0];
		}

		$aParts = array();

		$sMainCharset = '';
		$bOneCharset = true;

		for ($iIndex = 0, $iLen = \count($aEncodeArray); $iIndex < $iLen; $iIndex++)
		{
			$aTempArr = array('', $aEncodeArray[$iIndex]);
			if ('=?' === \substr(\trim($aTempArr[1]), 0, 2))
			{
				$iPos = \strpos($aTempArr[1], '?', 2);
				$aTempArr[0] = \substr($aTempArr[1], 2, $iPos - 2);
				$sEncType = \strtoupper($aTempArr[1]{$iPos + 1});
				switch ($sEncType)
				{
					case 'Q':
						$sHeaderValuePart = \str_replace('_', ' ', $aTempArr[1]);
						$aTempArr[1] = \quoted_printable_decode(\substr(
							$sHeaderValuePart, $iPos + 3, \strlen($sHeaderValuePart) - $iPos - 5));
						break;
					case 'B':
						$sHeaderValuePart = $aTempArr[1];
						$aTempArr[1] = \MailSo\Base\Utils::Base64Decode(\substr(
							$sHeaderValuePart, $iPos + 3, \strlen($sHeaderValuePart) - $iPos - 5));
						break;
				}
			}

			if (0 < \strlen($aTempArr[0]))
			{
				$sCharset = 0 === \strlen($sForcedIncomingCharset) ? $aTempArr[0] : $sForcedIncomingCharset;

				if ('' === $sMainCharset)
				{
					$sMainCharset = $sCharset;
				}
				else if ($sMainCharset !== $sCharset)
				{
					$bOneCharset = false;
				}
			}

			$aParts[] = array(
				$aEncodeArray[$iIndex],
				$aTempArr[1],
				$sCharset
			);

			unset($aTempArr);
		}

		for ($iIndex = 0, $iLen = \count($aParts); $iIndex < $iLen; $iIndex++)
		{
			if ($bOneCharset)
			{
				$sValue = \str_replace($aParts[$iIndex][0], $aParts[$iIndex][1], $sValue);
			}
			else
			{
				$sValue = \str_replace($aParts[$iIndex][0],
					\MailSo\Base\Utils::ConvertEncoding($aParts[$iIndex][1], $aParts[$iIndex][2], \MailSo\Base\Enumerations\Charset::UTF_8),
					$sValue);
			}
		}

		if ($bOneCharset && 0 < \strlen($sMainCharset))
		{
			$sValue = \MailSo\Base\Utils::ConvertEncoding($sValue, $sMainCharset, \MailSo\Base\Enumerations\Charset::UTF_8);
		}

		return $sValue;
	}

	/**
	 * @param string $sEncodeType
	 * @param string $sValue
	 *
	 * @return string
	 */
	public static function EncodeUnencodedValue($sEncodeType, $sValue)
	{
		$sValue = \trim($sValue);
		if (0 < \strlen($sValue) && !\MailSo\Base\Utils::IsAscii($sValue))
		{
			switch (\strtoupper($sEncodeType))
			{
				case 'B':
					$sValue = '=?'.\strtolower(\MailSo\Base\Enumerations\Charset::UTF_8).
						'?B?'.\base64_encode($sValue).'?=';
					break;

				case 'Q':
					$sValue = '=?'.\strtolower(\MailSo\Base\Enumerations\Charset::UTF_8).
						'?Q?'.\str_replace(array('?', ' ', '_'), array('=3F', '_', '=5F'),
							\quoted_printable_encode($sValue)).'?=';
					break;
			}
		}

		return $sValue;
	}

	/**
	 * @unused
	 *
	 * @param string $sEncodeType
	 * @param string $sEncodeCharset
	 * @param string $sValue
	 * @param string $sHeaderName = ''
	 *
	 * @return string
	 */
	public static function EncodeHeaderValue($sEncodeType, $sEncodeCharset, $sValue, $sHeaderName = '')
	{
		$sValue = \trim($sValue);

//		return \mb_encode_mimeheader($sValue,
//			\MailSo\Base\Enumerations\Charset::UTF_8, 'Q',
//			\MailSo\Mime\Enumerations\Constants::CRLF);

//		$splitWords = true;
//		if ($splitWords) {
//			$words = \array_map(function($word) use ($sEncodeCharset) {
//				$header = \iconv_mime_encode('Header', $word, array(
//					'scheme'         => 'Q',
//					'line-length'    => 78,
//					'output-charset' => $sEncodeCharset,
//				));
//				return \str_replace('Header: ', '', $header);
//			}, \explode(' ', $sValue));
//			return \implode("\r\n ", $words);
//		}
//
//		$header = \iconv_mime_encode('Header', $sValue, array(
//			'scheme'         => 'Q',
//			'line-length'    => 998,
//			'output-charset' => $sEncodeCharset,
//		));
//		return \str_replace('Header: ', '', $header);
//
//		$aPreferences = array(
//			'input-charset' => \MailSo\Base\Enumerations\Charset::UTF_8,
//			'output-charset' => $sEncodeCharset,
//			'line-length' => \MailSo\Mime\Enumerations\Constants::LINE_LENGTH,
//			'line-break-chars' => \MailSo\Mime\Enumerations\Constants::CRLF
//		);
//
//		if (\in_array(\strtoupper($sEncodeType), array('B', 'Q')))
//		{
//			$aPreferences['scheme'] = \strtoupper($sEncodeType);
//		}
//
//		$sHeaderName = 0 === \strlen($sHeaderName) ? 'X-Header' : $sHeaderName;
//		$sValue = \iconv_mime_encode($sHeaderName, $sValue, $aPreferences);
//		return \trim(substr($sValue, \strlen($sHeaderName) + 1));

		if (0 < \strlen($sValue) && !\MailSo\Base\Utils::IsAscii($sValue))
		{
			switch (\strtoupper($sEncodeType))
			{
				case 'B':
					$sValue = '=?'.\strtolower($sEncodeCharset).'?B?'.\base64_encode($sValue).'?=';
					break;

				case 'Q':
					$sValue = '=?'.\strtolower($sEncodeCharset).'?Q?'.\str_replace(
						array('?', ' ', '_'), array('=3F', '_', '=5F'),
						\quoted_printable_encode($sValue)).'?=';
					break;
			}
		}

		return \trim($sValue);
	}

	/**
	 * @param string $sEmail
	 *
	 * @return string
	 */
	public static function GetAccountNameFromEmail($sEmail)
	{
		$sResult = '';
		if (0 < \strlen($sEmail))
		{
			$iPos = \strpos($sEmail, '@');
			$sResult = (false === $iPos) ? $sEmail : \substr($sEmail, 0, $iPos);
		}

		return $sResult;
	}

	/**
	 * @param string $sEmail
	 *
	 * @return string
	 */
	public static function GetDomainFromEmail($sEmail)
	{
		$sResult = '';
		if (0 < \strlen($sEmail))
		{
			$iPos = \strpos($sEmail, '@');
			if (false !== $iPos && 0 < $iPos)
			{
				$sResult = \substr($sEmail, $iPos + 1);
			}
		}

		return $sResult;
	}

	/**
	 * @param string $sFileName
	 *
	 * @return string
	 */
	public static function GetFileExtension($sFileName)
	{
		$iLast = \strrpos($sFileName, '.');
		return false === $iLast ? '' : \substr($sFileName, $iLast + 1);
	}

	/**
	 * @param string $sFileName
	 *
	 * @return string
	 */
	public static function MimeContentType($sFileName)
	{
		$sResult = 'application/octet-stream';

		$aMimeTypes = array(

			'eml'	=> 'message/rfc822',
			'mime'	=> 'message/rfc822',
			'txt'	=> 'text/plain',
			'text'	=> 'text/plain',
			'def'	=> 'text/plain',
			'list'	=> 'text/plain',
			'in'	=> 'text/plain',
			'ini'	=> 'text/plain',
			'log'	=> 'text/plain',
			'sql'	=> 'text/plain',
			'cfg'	=> 'text/plain',
			'conf'	=> 'text/plain',
			'rtx'	=> 'text/richtext',
			'vcard'	=> 'text/vcard',
			'vcf'	=> 'text/vcard',
			'htm'	=> 'text/html',
			'html'	=> 'text/html',
			'csv'	=> 'text/csv',
			'ics'	=> 'text/calendar',
			'ifb'	=> 'text/calendar',
			'xml'	=> 'text/xml',
			'json'	=> 'application/json',
			'swf'	=> 'application/x-shockwave-flash',
			'hlp'	=> 'application/winhlp',
			'wgt'	=> 'application/widget',
			'chm'	=> 'application/vnd.ms-htmlhelp',
			'p10'	=> 'application/pkcs10',
			'p7c'	=> 'application/pkcs7-mime',
			'p7m'	=> 'application/pkcs7-mime',
			'p7s'	=> 'application/pkcs7-signature',
			'ttf'	=> 'application/x-ttf',
			'torrent'	=> 'application/x-bittorrent',

			// scripts
			'js'	=> 'application/javascript',
			'pl'	=> 'text/perl',
			'css'	=> 'text/css',
			'asp'	=> 'text/asp',
			'php'	=> 'application/x-httpd-php',
			'php3'	=> 'application/x-httpd-php',
			'php4'	=> 'application/x-httpd-php',
			'php5'	=> 'application/x-httpd-php',
			'phtml'	=> 'application/x-httpd-php',

			// images
			'png'	=> 'image/png',
			'jpg'	=> 'image/jpeg',
			'jpeg'	=> 'image/jpeg',
			'jpe'	=> 'image/jpeg',
			'jfif'	=> 'image/jpeg',
			'gif'	=> 'image/gif',
			'bmp'	=> 'image/bmp',
			'cgm'	=> 'image/cgm',
			'ief'	=> 'image/ief',
			'ico'	=> 'image/x-icon',
			'tif'	=> 'image/tiff',
			'tiff'	=> 'image/tiff',
			'svg'	=> 'image/svg+xml',
			'svgz'	=> 'image/svg+xml',
			'djv'	=> 'image/vnd.djvu',
			'djvu'	=> 'image/vnd.djvu',
			'webp'	=> 'image/webp',

			// archives
			'zip'	=> 'application/zip',
			'7z'	=> 'application/x-7z-compressed',
			'rar'	=> 'application/x-rar-compressed',
			'exe'	=> 'application/x-msdownload',
			'dll'	=> 'application/x-msdownload',
			'scr'	=> 'application/x-msdownload',
			'com'	=> 'application/x-msdownload',
			'bat'	=> 'application/x-msdownload',
			'msi'	=> 'application/x-msdownload',
			'cab'	=> 'application/vnd.ms-cab-compressed',
			'gz'	=> 'application/x-gzip',
			'tgz'	=> 'application/x-gzip',
			'bz'	=> 'application/x-bzip',
			'bz2'	=> 'application/x-bzip2',
			'deb'	=> 'application/x-debian-package',

			// fonts
			'psf'	=> 'application/x-font-linux-psf',
			'otf'	=> 'application/x-font-otf',
			'pcf'	=> 'application/x-font-pcf',
			'snf'	=> 'application/x-font-snf',
			'ttf'	=> 'application/x-font-ttf',
			'ttc'	=> 'application/x-font-ttf',

			// audio
			'mp3'	=> 'audio/mpeg',
			'amr'	=> 'audio/amr',
			'aac'	=> 'audio/x-aac',
			'aif'	=> 'audio/x-aiff',
			'aifc'	=> 'audio/x-aiff',
			'aiff'	=> 'audio/x-aiff',
			'wav'	=> 'audio/x-wav',
			'wma'	=> 'audio/x-ms-wma',
			'wax'	=> 'audio/x-ms-wax',
			'midi'	=> 'audio/midi',
			'mp4a'	=> 'audio/mp4',
			'ogg'	=> 'audio/ogg',
			'weba'	=> 'audio/webm',
			'ra'	=> 'audio/x-pn-realaudio',
			'ram'	=> 'audio/x-pn-realaudio',
			'rmp'	=> 'audio/x-pn-realaudio-plugin',
			'm3u'	=> 'audio/x-mpegurl',

			// video
			'flv'	=> 'video/x-flv',
			'qt'	=> 'video/quicktime',
			'mov'	=> 'video/quicktime',
			'wmv'	=> 'video/windows-media',
			'avi'	=> 'video/x-msvideo',
			'mpg'	=> 'video/mpeg',
			'mpeg'	=> 'video/mpeg',
			'mpe'	=> 'video/mpeg',
			'm1v'	=> 'video/mpeg',
			'm2v'	=> 'video/mpeg',
			'3gp'	=> 'video/3gpp',
			'3g2'	=> 'video/3gpp2',
			'h261'	=> 'video/h261',
			'h263'	=> 'video/h263',
			'h264'	=> 'video/h264',
			'jpgv'	=> 'video/jpgv',
			'mp4v'	=> 'video/mp4',
			'mpg4'	=> 'video/mp4',
			'ogv'	=> 'video/ogg',
			'webm'	=> 'video/webm',
			'm4v'	=> 'video/x-m4v',
			'asf'	=> 'video/x-ms-asf',
			'asx'	=> 'video/x-ms-asf',
			'wm'	=> 'video/x-ms-wm',
			'wmv'	=> 'video/x-ms-wmv',
			'wmx'	=> 'video/x-ms-wmx',
			'wvx'	=> 'video/x-ms-wvx',
			'movie'	=> 'video/x-sgi-movie',

			// adobe
			'pdf'	=> 'application/pdf',
			'psd'	=> 'image/vnd.adobe.photoshop',
			'ai'	=> 'application/postscript',
			'eps'	=> 'application/postscript',
			'ps'	=> 'application/postscript',

			// ms office
			'doc'	=> 'application/msword',
			'docx'	=> 'application/msword',
			'rtf'	=> 'application/rtf',
			'xls'	=> 'application/vnd.ms-excel',
			'ppt'	=> 'application/vnd.ms-powerpoint',

			// open office
			'odt'	=> 'application/vnd.oasis.opendocument.text',
			'ods'	=> 'application/vnd.oasis.opendocument.spreadsheet'

		);

		$sExt = \strtolower(\MailSo\Base\Utils::GetFileExtension($sFileName));
		if (0 < \strlen($sExt) && isset($aMimeTypes[$sExt]))
		{
			$sResult = $aMimeTypes[$sExt];
		}

		return $sResult;
	}

	/**
	 * @staticvar bool $bValidateAction
	 *
	 * @param int &$iTimer
	 * @param int $iTimeToReset = 15
	 * @param int $iTimeToAdd = 30
	 *
	 * @return bool
	 */
	public static function ResetTimeLimit(&$iTimer, $iTimeToReset = 15, $iTimeToAdd = 30)
	{
		static $bValidateAction = null;
		if (null === $bValidateAction)
		{
			$bValidateAction = !((bool) @\ini_get('safe_mode')) &&
				\function_exists('set_time_limit') &&
				\is_callable('set_time_limit');
		}

		if ($bValidateAction)
		{
			$iTime = \time();
			if ($iTimeToReset < $iTime - $iTimer)
			{
				$iTimer = $iTime;
				\set_time_limit($iTimeToAdd);
			}
		}

		return $bValidateAction;
	}

	/**
	 * @param string $sText
	 *
	 * @return string
	 */
	public static function InlineRebuildStringToJsString($sText)
	{
		static $aJsonReplaces = array(
			array('\\', "\n", "\t", "\r", '\b', "\f", '"'),
			array('\\\\', '\\n', '\\t', '\\r', '\\b', '\\f', '\"')
		);

		return \str_replace('</script>', '<\/script>',
			\str_replace($aJsonReplaces[0], $aJsonReplaces[1], $sText));
	}

	/**
	 * @param mixed $mInput
	 *
	 * @return string
	 */
	public static function Php2js($mInput)
	{
		return \json_encode($mInput, defined('JSON_UNESCAPED_UNICODE') ? JSON_UNESCAPED_UNICODE : 0);

		if (\is_null($mInput))
		{
			return 'null';
		}
		else if ($mInput === false)
		{
			return 'false';
		}
		else if ($mInput === true)
		{
			return 'true';
		}
		else if (\is_scalar($mInput))
		{
			if (\is_float($mInput))
			{
				$mInput = \str_replace(',', '.', \strval($mInput));
			}

			return '"'.\MailSo\Base\Utils::InlineRebuildStringToJsString($mInput).'"';
		}

		$bIsList = true;
		for ($iIndex = 0, \reset($mInput), $iLen = \count($mInput); $iIndex < $iLen; $iIndex++, \next($mInput))
		{
			if (\key($mInput) !== $iIndex)
			{
				$bIsList = false;
				break;
			}
		}

		$aResult = array();
		if ($bIsList)
		{
			foreach ($mInput as $mValue)
			{
				$aResult[] = \MailSo\Base\Utils::Php2js($mValue);
			}
			return '['.\join(',', $aResult).']';
		}
		else
		{
			foreach ($mInput as $sKey => $mValue)
			{
				$aResult[] = \MailSo\Base\Utils::Php2js($sKey).':'.\MailSo\Base\Utils::Php2js($mValue);
			}
			return '{'.\join(',', $aResult).'}';
		}
	}

	/**
	 * @param string $sFileName
	 *
	 * @return string
	 */
	public static function ClearFileName($sFileName)
	{
		return \preg_replace('/[\s]+/', ' ',
			\str_replace(array('"', '/', '\\', '*', '?', '<', '>', '|', ':'), ' ', $sFileName));
	}

	/**
	 * @param string $sDir
	 *
	 * @return bool
	 */
	public static function RecRmDir($sDir)
	{
		if (@is_dir($sDir))
		{
			$aObjects = scandir($sDir);
			foreach ($aObjects as $sObject)
			{
				if ('.' !== $sObject && '..' !== $sObject)
				{
					if ('dir' === filetype($sDir.'/'.$sObject))
					{
						self::RecRmDir($sDir.'/'.$sObject);
					}
					else
					{
						@unlink($sDir.'/'.$sObject);
					}
				}
			}

			return @rmdir($sDir);
		}

		return false;
	}

	/**
	 * @param string $sSource
	 * @param string $sDestination
	 */
	public static function CopyDir($sSource, $sDestination)
	{
		if (is_dir($sSource))
		{
			if (!is_dir($sDestination))
			{
				mkdir($sDestination);
			}

			$oDirectory = dir($sSource);
			if ($oDirectory)
			{
				while (false !== ($sRead = $oDirectory->read()))
				{
					if ('.' === $sRead || '..' === $sRead)
					{
						continue;
					}

					$sPathDir = $sSource.'/'.$sRead;
					if (is_dir($sPathDir))
					{
						self::CopyDir($sPathDir, $sDestination.'/'.$sRead);
						continue;
					}

					copy($sPathDir, $sDestination.'/'.$sRead);
				}

				$oDirectory->close();
			}
		}
	}

	/**
	 * @param string $sUtfString
	 * @param int $iLength
	 *
	 * @return string
	 */
	public static function Utf8Truncate($sUtfString, $iLength)
	{
		if (\strlen($sUtfString) <= $iLength)
		{
			return $sUtfString;
		}

		while ($iLength >= 0)
		{
			if ((\ord($sUtfString[$iLength]) < 0x80) || (\ord($sUtfString[$iLength]) >= 0xC0))
			{
				return \substr($sUtfString, 0, $iLength);
			}

			$iLength--;
		}

		return '';
	}

	/**
	 * @param string $sUtfString
	 * @param string $sReplaceOn = ''
	 *
	 * @return string
	 */
	public static function Utf8Clear($sUtfString, $sReplaceOn = '')
	{
//		$sUtfString = @\iconv('UTF-8', 'UTF-8//IGNORE', $sUtfString);

		$sUtfString = \preg_replace(
			'/[\x00-\x08\x10\x0B\x0C\x0E-\x1F\x7F]'.
			'|[\x00-\x7F][\x80-\xBF]+'.
			'|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*'.
			'|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})'.
			'|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/S',
			$sReplaceOn, $sUtfString);

		$sUtfString = \preg_replace(
			'/\xE0[\x80-\x9F][\x80-\xBF]'.
			'|\xED[\xA0-\xBF][\x80-\xBF]/S', $sReplaceOn, $sUtfString);

		return $sUtfString;
	}

	/**
	 * @param string $sString
	 *
	 * @return bool
	 */
	public static function IsRTL($sUtfString)
	{
		// \x{0591}-\x{05F4} - Hebrew
		// \x{FB1D}-\x{FB40} - Hebrew ?
		// \x{0621}-\x{064A} - Arabic
		return 0 < (int) preg_match('/[\x{0591}-\x{05F4}\x{FB1D}-\x{FB40}\x{0621}-\x{064A}]/u', $sUtfString);
	}

	/**
	 * @param string $sString
	 *
	 * @return string
	 */
	public static function Base64Decode($sString)
	{
		$sResultString = \base64_decode($sString, true);
		if (false === $sResultString)
		{
			$sString = \str_replace(array(' ', "\r", "\n", "\t"), '', $sString);
			if (false !== \strpos(\trim(\trim($sString), '='), '='))
			{
				$sString = \preg_replace('/=([^=])/', '= $1', $sString);
				$aStrings = \explode(' ', $sString);
				foreach ($aStrings as $iIndex => $sParts)
				{
					$aStrings[$iIndex] = \base64_decode($sParts);
				}

				$sResultString = \implode('', $aStrings);
			}
			else
			{
				$sResultString = \base64_decode($sString);
			}
		}

		return $sResultString;
	}

	/**
	 * @param string $sValue
	 *
	 * @return string
	 */
	public static function UrlSafeBase64Encode($sValue)
	{
		return \str_replace(array('+', '/', '='), array('-', '_', '.'), \base64_encode($sValue));
	}

	/**
	 * @param string $sValue
	 *
	 * @return string
	 */
	public static function UrlSafeBase64Decode($sValue)
	{
		$sData = \str_replace(array('-', '_', '.'), array('+', '/', '='), $sValue);
		$sMode = \strlen($sData) % 4;
		if ($sMode)
		{
			$sData .= \substr('====', $sMode);
		}

		return \MailSo\Base\Utils::Base64Decode($sData);
	}

	/**
	 *
	 * @param resource $fResource
	 * @param int $iBufferLen = 8192
	 *
	 * @return bool
	 */
	public static function FpassthruWithTimeLimitReset($fResource, $iBufferLen = 8192)
	{
		$iTimer = 0;
		$bResult = false;
		if (\is_resource($fResource))
		{
			while (!\feof($fResource))
			{
				$sBuffer = \fread($fResource, $iBufferLen);
				if (false !== $sBuffer)
				{
					echo $sBuffer;
					\MailSo\Base\Utils::ResetTimeLimit($iTimer);
					continue;
				}

				break;
			}

			$bResult = true;
		}

		return $bResult;
	}

	/**
	 * @param resource $rRead
	 * @param array $aWrite
	 * @param int $iBufferLen = 8192
	 * @param bool $bResetTimeLimit = true
	 * @param bool $bFixCrLf = false
	 *
	 * @return int|bool
	 */
	public static function MultipleStreamWriter($rRead, $aWrite, $iBufferLen = 8192, $bResetTimeLimit = true, $bFixCrLf = false)
	{
		$iTimer = 0;
		$mResult = false;
		if ($rRead && \is_array($aWrite) && 0 < \count($aWrite))
		{
			$mResult = 0;
			while (!\feof($rRead))
			{
				$sBuffer = \fread($rRead, $iBufferLen);
				if (false === $sBuffer)
				{
					$mResult = false;
					break;
				}

				if (0 === $iBufferLen || '' === $sBuffer)
				{
					break;
				}

				if ($bFixCrLf)
				{
					$sBuffer = \str_replace("\n", "\r\n", \str_replace("\r", '', $sBuffer));
				}

				$mResult += \strlen($sBuffer);

				foreach ($aWrite as $rWriteStream)
				{
					$mWriteResult = \fwrite($rWriteStream, $sBuffer);
					if (false === $mWriteResult)
					{
						$mResult = false;
						break 2;
					}
				}

				if ($bResetTimeLimit)
				{
					\MailSo\Base\Utils::ResetTimeLimit($iTimer);
				}
			}
		}

		return $mResult;
	}

	/**
	 * @param string $sUtfModifiedString
	 *
	 * @return string
	 */
	public static function ModifiedToPlainUtf7($sUtfModifiedString)
	{
		$sUtf = '';
		$bBase = false;

		for ($iIndex = 0, $iLen = \strlen($sUtfModifiedString); $iIndex < $iLen; $iIndex++)
		{
			if ('&' === $sUtfModifiedString[$iIndex])
			{
				if (isset($sUtfModifiedString[$iIndex+1]) && '-' === $sUtfModifiedString[$iIndex + 1])
				{
					$sUtf .= '&';
					$iIndex++;
				}
				else
				{
					$sUtf .= '+';
					$bBase = true;
				}
			}
			else if ($sUtfModifiedString[$iIndex] == '-' && $bBase)
			{
				$bBase = false;
			}
			else
			{
				if ($bBase && ',' === $sUtfModifiedString[$iIndex])
				{
					$sUtf .= '/';
				}
				else if (!$bBase && '+' === $sUtfModifiedString[$iIndex])
				{
					$sUtf .= '+-';
				}
				else
				{
					$sUtf .= $sUtfModifiedString[$iIndex];
				}
			}
		}

		return $sUtf;
	}

	/**
	 * @param string $sStr
	 *
	 * @return string|bool
	 */
	public static function Utf7ModifiedToUtf8($sStr)
	{
		$aArray = array(-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,
			-1,-1,-1,-1,-1,-1,-1,-1,-1,62, 63,-1,-1,-1,52,53,54,55,56,57,58,59,60,61,-1,-1,-1,-1,-1,-1,-1,0,1,2,3,4,5,6,7,8,9,
			10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,-1,-1,-1,-1,-1,-1,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,
			41,42,43,44,45,46,47,48,49,50,51,-1,-1,-1,-1,-1);

		$sResult = '';
		$bError = false;
		$iLen = \strlen($sStr);

		for ($iIndex = 0; $iLen > 0; $iIndex++, $iLen--)
		{
			$sChar = $sStr{$iIndex};
			if ($sChar == '&')
			{
				$iIndex++;
				$iLen--;

				$sChar = isset($sStr{$iIndex}) ? $sStr{$iIndex} : null;
				if ($sChar === null)
				{
					break;
				}

				if ($iLen && $sChar == '-')
				{
					$sResult .= '&';
					continue;
				}

				$iCh = 0;
				$iK = 10;
				for (; $iLen > 0; $iIndex++, $iLen--)
				{
					$sChar = $sStr{$iIndex};

					$iB = $aArray[\ord($sChar)];
					if ((\ord($sChar) & 0x80) || $iB == -1)
					{
						break;
					}

					if ($iK > 0)
					{
						$iCh |= $iB << $iK;
						$iK -= 6;
					}
					else
					{
						$iCh |= $iB >> (-$iK);
						if ($iCh < 0x80)
						{
							if (0x20 <= $iCh && $iCh < 0x7f)
							{
								return $bError;
							}

							$sResult .= \chr($iCh);
						}
						else if ($iCh < 0x800)
						{
							$sResult .= \chr(0xc0 | ($iCh >> 6));
							$sResult .= \chr(0x80 | ($iCh & 0x3f));
						}
						else
						{
							$sResult .= \chr(0xe0 | ($iCh >> 12));
							$sResult .= \chr(0x80 | (($iCh >> 6) & 0x3f));
							$sResult .= \chr(0x80 | ($iCh & 0x3f));
						}

						$iCh = ($iB << (16 + $iK)) & 0xffff;
						$iK += 10;
					}
				}

				if (($iCh || $iK < 6) ||
					(!$iLen || $sChar != '-') ||
					($iLen > 2 && '&' === $sStr{$iIndex+1} && '-' !==  $sStr{$iIndex+2}))
				{
					return $bError;
				}
			}
			else if (\ord($sChar) < 0x20 || \ord($sChar) >= 0x7f)
			{
				return $bError;
			}
			else
			{
				$sResult .= $sChar;
			}
		}

		return $sResult;
	}

	/**
	 * @param string $sStr
	 *
	 * @return string|bool
	 */
	public static function Utf8ToUtf7Modified($sStr)
	{
		$sArray = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S',
			'T','U','V','W','X','Y','Z', 'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o',
			'p','q','r','s','t','u','v','w','x','y','z', '0','1','2','3','4','5','6','7','8','9','+',',');

		$sLen = \strlen($sStr);
		$bIsB = false;
		$iIndex = $iN = 0;
		$sReturn = '';
		$bError = false;
		$iCh = $iB = $iK = 0;

		while ($sLen)
		{
			$iC = \ord($sStr{$iIndex});
			if ($iC < 0x80)
			{
				$iCh = $iC;
				$iN = 0;
			}
			else if ($iC < 0xc2)
			{
				return $bError;
			}
			else if ($iC < 0xe0)
			{
				$iCh = $iC & 0x1f;
				$iN = 1;
			}
			else if ($iC < 0xf0)
			{
				$iCh = $iC & 0x0f;
				$iN = 2;
			}
			else if ($iC < 0xf8)
			{
				$iCh = $iC & 0x07;
				$iN = 3;
			}
			else if ($iC < 0xfc)
			{
				$iCh = $iC & 0x03;
				$iN = 4;
			}
			else if ($iC < 0xfe)
			{
				$iCh = $iC & 0x01;
				$iN = 5;
			}
			else
			{
				return $bError;
			}

			$iIndex++;
			$sLen--;

			if ($iN > $sLen)
			{
				return $bError;
			}

			for ($iJ = 0; $iJ < $iN; $iJ++)
			{
				$iO = \ord($sStr{$iIndex+$iJ});
				if (($iO & 0xc0) != 0x80)
				{
					return $bError;
				}

				$iCh = ($iCh << 6) | ($iO & 0x3f);
			}

			if ($iN > 1 && !($iCh >> ($iN * 5 + 1)))
			{
				return $bError;
			}

			$iIndex += $iN;
			$sLen -= $iN;

			if ($iCh < 0x20 || $iCh >= 0x7f)
			{
				if (!$bIsB)
				{
					$sReturn .= '&';
					$bIsB = true;
					$iB = 0;
					$iK = 10;
				}

				if ($iCh & ~0xffff)
				{
					$iCh = 0xfffe;
				}

				$sReturn .= $sArray[($iB | $iCh >> $iK)];
				$iK -= 6;
				for (; $iK >= 0; $iK -= 6)
				{
					$sReturn .= $sArray[(($iCh >> $iK) & 0x3f)];
				}

				$iB = ($iCh << (-$iK)) & 0x3f;
				$iK += 16;
			}
			else
			{
				if ($bIsB)
				{
					if ($iK > 10)
					{
						$sReturn .= $sArray[$iB];
					}
					$sReturn .= '-';
					$bIsB = false;
				}

				$sReturn .= \chr($iCh);
				if ('&' === \chr($iCh))
				{
					$sReturn .= '-';
				}
			}
		}

		if ($bIsB)
		{
			if ($iK > 10)
			{
				$sReturn .= $sArray[$iB];
			}

			$sReturn .= '-';
		}

		return $sReturn;
	}

	/**
	 * @param string $mValue
	 *
	 * @return string
	 */
	public static function ClearNullBite($mValue)
	{
		return \str_replace('%00', '', $mValue);
	}

	/**
	 * @param mixed $mValue
	 * @param bool $bClearNullBite = false
	 *
	 * @return mixed
	 */
	public static function StripSlashesValue($mValue, $bClearNullBite = false)
	{
		static $bIsMagicQuotesOn = null;
		if (null === $bIsMagicQuotesOn)
		{
			$bIsMagicQuotesOn = (bool) @\ini_get('magic_quotes_gpc');
		}

		if (!$bIsMagicQuotesOn)
		{
			return $bClearNullBite && \is_string($mValue) ? \MailSo\Base\Utils::ClearNullBite($mValue) : $mValue;
		}

		$sType = \gettype($mValue);
		if ('string' === $sType)
		{
			return \stripslashes($bClearNullBite ? \MailSo\Base\Utils::ClearNullBite($mValue) : $mValue);
		}
		else if ('array' === $sType)
		{
			$aReturnValue = array();
			$mValueKeys = \array_keys($mValue);
			foreach ($mValueKeys as $sKey)
			{
				$aReturnValue[$sKey] = \MailSo\Base\Utils::StripSlashesValue($mValue[$sKey], $bClearNullBite);
			}

			return $aReturnValue;
		}

		return $mValue;
	}
}
