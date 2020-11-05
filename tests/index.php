<?php


use Poppy\Faker\Factory;

include dirname(__DIR__) . '/src/autoload.php';

$faker = Factory::create('zh_CN');
function py_faker_desc($desc, $code, $maxLength = 50, $simple = true)
{
	$faker = Factory::create('zh_CN');
	ob_start();
	eval("\$result = $code;");
	print_r($result);
	$content = ob_get_clean();
	$codeHl  = highlight_string($code, true);
	$code    = str_pad($code, $maxLength + 3, ' ', STR_PAD_RIGHT);
	if ($simple) {
		echo '// ' . $desc . PHP_EOL . $code . ' // ' . $content . PHP_EOL;
	}
	else {
		echo "<pre style='border-bottom: 1px solid #EFEFEF;line-height: 1.4;font-size: 13px;padding-bottom: 8px;'>
{$desc}{$codeHl}{$content}</pre>";
	}

}

$md = isset($_GET['md']);

/**
 * @param      $title
 * @param      $items
 * @param bool $md
 */
function py_example($title, $items, $md = true)
{
	if ($md) {
		echo PHP_EOL . PHP_EOL . '### ' . $title . PHP_EOL . PHP_EOL;
	}
	else {
		echo "<h2 style='border-bottom: 1px solid #EFEFEF;line-height: 1.4;font-size: 18px;height: 35px;'>{$title}</h2>";
	}

	if ($md) {
		echo '```' . PHP_EOL;
	}
	$maxLength = 0;
	foreach ($items as $item) {
		$length    = strlen((string) $item[1]);
		$maxLength = $length > $maxLength ? $length : $maxLength;
	}

	if ($maxLength > 50) {
		$maxLength = 50;
	}

	foreach ($items as $item) {
		py_faker_desc($item[0], (string) $item[1], $maxLength, $md);
	}
	if ($md) {
		echo '```' . PHP_EOL;
	}
}


py_example('Base', [
	['生成随机整数 0 - 9', '$faker->randomDigit;'],
	['生成唯一整数', '$faker->unique()->randomDigit;'],
	['生成随机不为空的整数', '$faker->randomDigitNotNull;'],
	['生成随机数字', '$faker->randomNumber($nbDigits = 5, $strict = false);'],
	['生成随机浮点数', '$faker->randomFloat($nbMaxDecimals = null, $min = 0, $max = null);'],
	['在指定范围内生成随机数', '$faker->numberBetween($min = 1000, $max = 9000);'],
	['生成随机字符', '$faker->randomLetter;'],
	['在给定的数组中,随机生成给定的个数字符', '$faker->randomElements($array = [\'a\', \'b\', \'c\'], $count = 2);'],
	['在给定的数组中,生成单个随机字符', '$faker->randomElement($array = [\'a\', \'b\', \'c\']);'],
	['打乱给定的字符串', '$faker->shuffle(\'hello, world\');'],
	['打乱给定的数组', '$faker->shuffle([1, 2, 3]);'],
	['给占位符生成随机整数 (数字为#)', '$faker->numerify(\'Hello ###\');'],
	['给占位符生成随机字符串 (字符串为?)', '$faker->lexify(\'Hello ???\');'],
	['给占位符生成混合的随机字符串', '$faker->bothify(\'Hello ##??\');'],
	['给占位符生成随机的字符(字母、数字、符号)', '$faker->asciify(\'Hello ***\');'],
	['根据正则规则生成随机字符', '$faker->regexify(\'[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\');'],
], $md);


py_example('Lorem', [
	['生成随机个数的字符串', '$faker->word;'],
	['随机生成指定个数的字符串', '$faker->words($nb = 3, $asText = false);'],
	['随机生成一条语句', '$faker->sentence($nbWords = 6, $variableNbWords = true);'],
	['随机生成指定条数的语句', '$faker->sentences($nb = 3, $asText = false);'],
	['随机生成一个段落', '$faker->paragraph($nbSentences = 3, $variableNbSentences = true);'],
	['随机生成指定个数段落', '$faker->paragraphs($nb = 3, $asText = false);'],
	['随机生成一个文本', '$faker->text($maxNbChars = 200);'],
], $md);


py_example('Person', [
	['职位', '$faker->title;'],
	['称谓', '$faker->titleMale;'],
	['女性称谓', '$faker->titleFemale;'],
	['姓名', '$faker->name'],
	['名字', '$faker->firstName'],
	['男性名字', '$faker->firstNameMale'],
	['女性名字', '$faker->firstNameFemale'],
	['姓', '$faker->lastName'],
	['随机生成一个可以校验的身份证号', '$faker->idNumber'],
], $md);


py_example('Address', [
	['随机生成省份/州', '$faker->state;'],
	['随机城市省份/州缩写', '$faker->stateAbbr;'],
	['随机生成城市后缀', '$faker->citySuffix;'],
	['随机生成街道后缀', '$faker->streetSuffix;'],
	['随机生成建筑编号', '$faker->buildingNumber;'],
	['随机生成城市', '$faker->city;'],
	['随机生成街道名', '$faker->streetName; '],
	['随机生成街道地址', '$faker->streetAddress;'],
	['随机生成邮编', '$faker->postcode;'],
	['随机生成地址', '$faker->address;'],
	['随机生成国家', '$faker->country;'],
	['随机生成纬度', '$faker->latitude($min = -90, $max = 90);'],
	['随机生成经度', '$faker->longitude($min = -180, $max = 180);'],
], $md);


py_example('Phone Number', [
	['生成随机电话号码', '$faker->phoneNumber;'],
	['随机生成e164电话', '$faker->e164PhoneNumber;'],
], $md);


py_example('Company', [
	['随机生成公司', '$faker->company;'],
	['随机生成公司后缀', '$faker->companySuffix;'],
	['随机生成职务', '$faker->jobTitle;'],
], $md);


py_example('Text', [
	['随机生成一段文本', '$faker->realText($maxNbChars = 200, $indexSize = 2);'],
], $md);


py_example('Datetime', [
	['随机生成时间戳', '$faker->unixTime($max = \'now\');'],
	['随机生成时间', '$faker->dateTime($max = \'now\', $timezone = date_default_timezone_get());'],
	[' dateTimeAd', '$faker->dateTimeAD;'],
	['随机生成ios8601时间', '$faker->iso8601($max = \'now\');'],
	['根据格式随机生成日期', '$faker->date($format = \'Y-m-d\', $max = \'now\');'],
	['根据格式随机生成时间', '$faker->time($format = \'H:i:s\', $max = \'now\');'],
	['生成指定范围的时间', '$faker->dateTimeBetween($startDate = \'-30 years\', $endDate = \'now\');'],
	['随机生成一个指定间隔的时间', '$faker->dateTimeInInterval($startDate = \'-30 years\', $interval = \'+ 5 days\', $timezone = date_default_timezone_get());'],
	['随机生成当前世纪的时间', '$faker->dateTimeThisCentury($max = \'now\', $timezone = date_default_timezone_get());'],
	['随机生成当前十年的时间', '$faker->dateTimeThisDecade($max = \'now\', $timezone = date_default_timezone_get());'],
	['随机生成当前年的时间', '$faker->dateTimeThisYear($max = \'now\', $timezone = date_default_timezone_get());'],
	['随机生成当前月的时间', '$faker->dateTimeThisMonth($max = \'now\', $timezone = date_default_timezone_get());'],
	['随机生成 am/pm', '$faker->amPm($max = \'now\');'],
	['随机生成月份的某一天', '$faker->dayOfMonth($max = \'now\');'],
	['随机生成星期', '$faker->dayOfWeek($max = \'now\');'],
	['随机生成月份', '$faker->month($max = \'now\');'],
	['随机生成月份的名称', '$faker->monthName($max = \'now\');'],
	['随机生成年份', '$faker->year($max = \'now\');'],
	['随机生成世纪', '$faker->century;'],
	['随机生成时区', '$faker->timezone;'],
], $md);


py_example('Internet', [
	['随机生成邮箱地址', '$faker->email;'],
	['随机生成安全的邮箱地址', '$faker->safeEmail;'],
	['随机生成免费的邮箱地址', '$faker->freeEmail;'],
	['随机生成公司邮箱地址', '$faker->companyEmail;'],
	['随机生成免费邮箱域名', '$faker->freeEmailDomain;'],
	['随机生成安全邮箱域名', '$faker->safeEmailDomain;'],
	['随机生成用户名', '$faker->userName;'],
	['随机生成密码', '$faker->password;'],
	['随机生成域名', '$faker->domainName;'],
	['随机生成域', '$faker->domainWord;'],
	['todo Tld', '$faker->tld;'],
	['随机生成url地址', '$faker->url;'],
	['随机生成块', '$faker->slug;'],
	['随机生成ipv4地址', '$faker->ipv4;'],
	['随机生成本地ipv4地址', '$faker->localIpv4;'],
	['随机生成ipv6地址', '$faker->ipv6;'],
	['随机生成mac地址', '$faker->macAddress;'],
], $md);


py_example('UserAgent', [
	['用户代理', '$faker->userAgent;'],
	['谷歌', '$faker->chrome;'],
	['火狐', '$faker->firefox; '],
	['Safari', '$faker->safari; '],
	['欧朋', '$faker->opera;'],
	['ie', '$faker->internetExplorer;'],
], $md);


py_example('Payment', [
	['随机生成信用卡类型', '$faker->creditCardType;'],
	['随机生成信用卡号', '$faker->creditCardNumber;'],
	['随机生成信用卡有效日期', '$faker->creditCardExpirationDate;'],
	['随机生成信用卡有效日期', '$faker->creditCardExpirationDateString;'],
	['随机生成信用卡明细', '$faker->creditCardDetails;'],
	['随机生成国际银行账号', '$faker->iban($countryCode = null); '],
	['todo 瑞士银行账号', '$faker->swiftBicNumber; '],
], $md);


py_example('Color', [
	['随机生成16进制颜色', '$faker->hexColor;'],
	['随机生成rgb格式的颜色', '$faker->rgbColor;'],
	['随机生成数组格式的rgb颜色', '$faker->rgbColorAsArray;'],
	['随机生成css格式的rgb颜色', '$faker->rgbCssColor;'],
	['随机生成颜色名称', '$faker->safeColorName; '],
	[' 颜色名称', '$faker->colorName;'],
], $md);


py_example('File', [
	['随机生成文件扩展名', '$faker->fileExtension;'],
	['随机生成mime类型', '$faker->mimeType;'],
], $md);


py_example('Image', [
	['随机生成图片地址', '$faker->phUrl($width = 640, $height = 480);'],
	['随机生成头像地址', '$faker->avatarUrl(300, \'girl\');'],
	['返回 Svg Url 地址', '$faker->svgUrl(100, 100)'],
], $md);


py_example('UUID', [
	['随机生成一个唯一字串', '$faker->uuid'],
], $md);


py_example('Calculator', [
	['随机生成13位ean码', '$faker->ean13;'],
	['随机生成8位ean码', '$faker->ean8;'],
	['随机生成13位isbn码', '$faker->isbn13;'],
	['随机生成10位isbn码', '$faker->isbn10;'],
], $md);


py_example('Miscellaneous', [
	['随机生成bool值 false', '$faker->boolean;'],
	['平衡的生成bool值', '$faker->boolean($chanceOfGettingTrue = 50);'],
	[' Md5', '$faker->md5;'],
	[' Sha1', '$faker->sha1;'],
	[' Sha256', '$faker->sha256;'],
	[' Locale', '$faker->locale;'],
	['随机生成国家编码', '$faker->countryCode;'],
	['随机生成语言编码', '$faker->languageCode;'],
	['随机生成货币代码', '$faker->currencyCode;'],
	[' Emoji', '$faker->emoji;'],
], $md);


py_example('Biased', [
	['在10到20之间得到一个随机数，有更多的几率接近20', '$faker->biasedNumberBetween($min = 10, $max = 20, $function = \'sqrt\');'],
], $md);


py_example('Html', [
	['随机生成一个不超过 $maxDepth层的html, 任何级别上都不超过$maxWidth个元素', '$faker->randomHtml($maxDepth = 2, $maxWidth = 3);'],
], $md);
