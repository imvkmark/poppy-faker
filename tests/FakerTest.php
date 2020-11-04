<?php namespace System\Tests\Classes;

use OverflowException;
use Poppy\Extension\Faker\Factory;
use Poppy\Framework\Application\TestCase;

class FakerTest extends TestCase
{
	protected $faker;

	public function setUp(): void
	{
		parent::setUp();
		$this->faker = Factory::create();
	}

	public function testBase()
	{
		//生成随机整数 0 - 9
		$randomDigit = $this->faker->randomDigit; // 0

		//生成随机不为空的整数
		$randomDigitNotNull = $this->faker->randomDigitNotNull; // 8

		//生成随机数字
		$randomNumber = $this->faker->randomNumber($nbDigits = null, $strict = false); // 3487065

		//生成随机浮点数
		$randomFloat = $this->faker->randomFloat($nbMaxDecimals = null, $min = 0, $max = null); // 45.013726488

		//在指定范围内生成随机数
		$numberBetween = $this->faker->numberBetween($min = 1000, $max = 9000); // 1027

		//生成随机字符
		$randomLetter = $this->faker->randomLetter; // k

		//在给定的数组中,随机生成给定的个数字符
		$randomElements = $this->faker->randomElements($array = ['a', 'b', 'c'], $count = 2); // array('c', 'a')

		//在给定的数组中,生成单个随机字符
		$randomElement = $this->faker->randomElement($array = ['a', 'b', 'c']); // "b"

		//打乱给定的字符串
		$shuffleStr = $this->faker->shuffle('hello, world'); // 'rlo,h eoldlw'

		//打乱给定的数组
		$shuffleArr = $this->faker->shuffle([1, 2, 3]); // array(2, 1, 3)

		//给占位符生成随机整数 (数字为#)
		$numerify = $this->faker->numerify('Hello ###'); // 'Hello 609'

		//给占位符生成随机字符串 (字符串为?)
		$lexify = $this->faker->lexify('Hello ???'); // 'Hello wgt'

		//给占位符生成混合的随机字符串
		$bothify = $this->faker->bothify('Hello ##??'); // 'Hello 42jz'

		//给占位符生成随机的字符(字母、数字、符号)
		$asciify = $this->faker->asciify('Hello ***'); // 'Hello R6+'

		//根据正则规则生成随机字符
		$regexify = $this->faker->regexify('[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}'); // "NXF@QJ87.XDR"

		var_dump(
			$randomDigit,
			$randomDigitNotNull,
			$randomNumber,
			$randomFloat,
			$numberBetween,
			$randomLetter,
			$randomElements,
			$randomElement,
			$shuffleStr,
			$shuffleArr,
			$numerify,
			$lexify,
			$bothify,
			$asciify,
			$regexify
		);
	}

	public function testLorem()
	{
		//生成随机个数的字符串
		$word = $this->faker->word; // 'aut'

		//随机生成指定个数的字符串
		$words = $this->faker->words($nb = 3, $asText = false); // array('porro', 'sed', 'magni')

		//随机生成一条语句
		$sentence = $this->faker->sentence($nbWords = 6, $variableNbWords = true); // 'Sit vitae voluptas sint non voluptates.'

		//随机生成指定条数的语句
		//参数 $asText是否作为文本, false:为数组,true:为一个字符串
		$sentences = $this->faker->sentences($nb = 3, $asText = false); // array('Optio quos qui illo error.', 'Laborum vero a officia id corporis.', 'Saepe provident esse hic eligendi.')

		//随机生成一个段落
		$paragraph = $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true); // 'Ut ab voluptas sed a nam. Sint autem inventore aut officia aut aut blanditiis. Ducimus eos odit amet et est ut eum.'

		//随机生成指定个数段落
		$paragraphs = $this->faker->paragraphs($nb = 3, $asText = false); // array('Quidem ut sunt et quidem est accusamus aut. Fuga est placeat rerum ut. Enim ex eveniet facere sunt.', 'Aut nam et eum architecto fugit repellendus illo. Qui ex esse veritatis.', 'Possimus omnis aut incidunt sunt. Asperiores incidunt iure sequi cum culpa rem. Rerum exercitationem est rem.')

		//随机生成一个文本
		$text = $this->faker->text($maxNbChars = 200); // 'Fuga totam reiciendis qui architecto fugiat nemo. Consequatur recusandae qui cupiditate eos quod.'

		var_dump($word, $words, $sentence, $sentences, $paragraph, $paragraphs, $text);
	}

	public function testPerson()
	{
		//随机生成任务称呼Mrs./Mr./Dr. ...
		$title = $this->faker->title($gender = null | 'male' | 'female'); // 'Ms.'

		//随机生成男性称呼
		$titleMale = $this->faker->titleMale; // 'Mr.'

		//随机生成女性称呼
		$titleFemale = $this->faker->titleFemale; // 'Ms.'

		//随机生成姓名
		$name = $this->faker->name($gender = null | 'male' | 'female'); // 'Dr. Zane Stroman'

		//随机生成名字
		$firstName = $this->faker->firstName($gender = null | 'male' | 'female'); // 'Maynard'

		//随机生成男性 名字
		$firstNameMale = $this->faker->firstNameMale; // 'Maynard'

		//随机生成女性 名字
		$firstNameFemale = $this->faker->firstNameFemale; // 'Rachel'

		//随机生成姓氏
		$lastName = $this->faker->lastName; // 'Zulauf'

		dump($title, $titleMale, $titleFemale, $name, $firstName, $firstNameMale, $firstNameFemale, $lastName);
	}

	public function testAddress()
	{
		//随机生成城市前缀town/port/haven...
		$cityPrefix = $this->faker->cityPrefix; // 'Lake'

		$secondaryAddress = $this->faker->secondaryAddress; // 'Suite 961'

		//随机生成省份/州
		$state = $this->faker->state; // 'NewMexico'

		//随机城市省份/州缩写
		$stateAbbr = $this->faker->stateAbbr; // 'OH'

		//随机生成城市后缀
		$citySuffix = $this->faker->citySuffix; // 'borough'

		//随机生成街道后缀
		$streetSuffix = $this->faker->streetSuffix; // 'Keys'

		//随机生成建筑编号
		$buildingNumber = $this->faker->buildingNumber; // '484'

		//随机生成城市
		$city = $this->faker->city; // 'West Judge'

		//随机生成街道名
		$streetName = $this->faker->streetName;  // 'Keegan Trail'

		//随机生成街道地址
		$streetAddress = $this->faker->streetAddress; // '439 Karley Loaf Suite 897'

		//随机生成邮编
		$postcode = $this->faker->postcode; // '17916'

		//随机生成地址
		$address = $this->faker->address; // '8888 Cummings Vista Apt. 101, Susanbury, NY 95473'

		//随机生成国家
		$country = $this->faker->country; // 'Falkland Islands (Malvinas)'

		//随机生成纬度
		$latitude = $this->faker->latitude($min = -90, $max = 90); // 77.147489

		//随机生成经度
		$longitude = $this->faker->longitude($min = -180, $max = 180); // 86.211205

		var_dump(
			$cityPrefix,
			$secondaryAddress,
			$state,
			$stateAbbr,
			$citySuffix,
			$streetSuffix,
			$buildingNumber,
			$city,
			$streetName,
			$streetAddress,
			$postcode,
			$address,
			$country,
			$latitude,
			$longitude
		);
	}

	public function testPhoneNumber()
	{
		//生成随机电话号码
		$phoneNumber = $this->faker->phoneNumber; // "(757) 833-3219 x158"

		//随机生成免费电话号码
		$tollFreePhoneNumber = $this->faker->tollFreePhoneNumber; // "888-205-1163"

		//随机生成e164电话
		$e164PhoneNumber = $this->faker->e164PhoneNumber; // "+8283952638578"

		var_dump($phoneNumber, $tollFreePhoneNumber, $e164PhoneNumber);
	}

	public function testCompany()
	{
		//随机生成公司
		$company = $this->faker->company; // "Jacobson-Reichert"

		//随机生成公司后缀
		$companySuffix = $this->faker->companySuffix; //  "Inc"

		//随机生成职务
		$jobTitle = $this->faker->jobTitle; // "Brazing Machine Operator"

		var_dump($company, $companySuffix, $jobTitle);
	}

	public function testRealText()
	{
		//随机生成一段文本
		$realText = $this->faker->realText($maxNbChars = 200, $indexSize = 2); // "And yet I wish you could manage it?) 'And what are they made of?' Alice asked in a shrill, passionate voice. 'Would YOU like cats if you were never even spoke to Time!' 'Perhaps not,' Alice replied."

		var_dump($realText);
	}

	public function testDateTime()
	{
		//随机生成时间戳
		$unixTime = $this->faker->unixTime($max = 'now'); // 58781813

		//随机生成时间
		$dateTime = $this->faker->dateTime($max = 'now', $timezone = date_default_timezone_get()); // DateTime('2008-04-25 08:37:17', 'UTC')

		$dateTimeAD = $this->faker->dateTimeAD; // DateTime('1800-04-29 20:38:49', 'Europe/Paris')

		//随机生成ios8601时间
		$iso8601 = $this->faker->iso8601($max = 'now'); // '1978-12-09T10:10:29+0000'

		//根据格式随机生成日期
		$date = $this->faker->date($format = 'Y-m-d', $max = 'now'); // '1979-06-09'

		//根据格式随机生成时间
		$time = $this->faker->time($format = 'H:i:s', $max = 'now'); // '20:49:42'

		//生成指定范围的时间
		$dateTimeBetween = $this->faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now'); // DateTime('2003-03-15 02:00:49', 'Africa/Lagos')

		//随机生成一个指定间隔的时间
		$dateTimeInInterval = $this->faker->dateTimeInInterval($startDate = '-30 years', $interval = '+ 5 days', $timezone = date_default_timezone_get()); // DateTime('2003-03-15 02:00:49', 'Antartica/Vostok')

		//随机生成当前世纪的时间
		$dateTimeThisCentury = $this->faker->dateTimeThisCentury($max = 'now', $timezone = date_default_timezone_get()); // DateTime('1915-05-30 19:28:21', 'UTC')

		//随机生成当前十年的时间
		$dateTimeThisDecade = $this->faker->dateTimeThisDecade($max = 'now', $timezone = date_default_timezone_get()); // DateTime('2007-05-29 22:30:48', 'Europe/Paris')

		//随机生成当前年的时间
		$dateTimeThisYear = $this->faker->dateTimeThisYear($max = 'now', $timezone = date_default_timezone_get()); // DateTime('2018-02-27 20:52:14', 'Africa/Lagos')

		//随机生成当前月的时间
		$dateTimeThisMonth = $this->faker->dateTimeThisMonth($max = 'now', $timezone = date_default_timezone_get()); //DateTime( "2018-06-15 15:44:58.000000", 'PRC')

		//随机生成 am/pm
		$amPm = $this->faker->amPm($max = 'now'); //"pm"

		//随机生成月份的某一天
		$dayOfMonth = $this->faker->dayOfMonth($max = 'now'); // '04'

		//随机生成星期
		$dayOfWeek = $this->faker->dayOfWeek($max = 'now'); // "Monday"

		//随机生成月份
		$month = $this->faker->month($max = 'now'); // "05"

		//随机生成月份的名称
		$monthName = $this->faker->monthName($max = 'now'); // "June"

		//随机生成年份
		$year = $this->faker->year($max = 'now'); // "1980"

		//随机生成世纪
		$century = $this->faker->century; // "XXI"

		//随机生成时区
		$timezone = $this->faker->timezone; // "Antarctica/Macquarie"

		var_dump(
			$unixTime,
			$dateTime,
			$dateTimeAD,
			$iso8601,
			$date,
			$time,
			$dateTimeBetween,
			$dateTimeInInterval,
			$dateTimeThisCentury,
			$dateTimeThisDecade,
			$dateTimeThisYear,
			$dateTimeThisMonth,
			$amPm,
			$dayOfMonth,
			$dayOfWeek,
			$month,
			$monthName,
			$year,
			$century,
			$timezone
		);
	}

	public function testInternet()
	{
		//随机生成邮箱地址
		$email = $this->faker->email; // "qnikolaus@gmail.com"

		//随机生成安全的邮箱地址
		$safeEmail = $this->faker->safeEmail; // "haven12@example.com"

		//随机生成免费的邮箱地址
		$freeEmail = $this->faker->freeEmail;// "lhowe@hotmail.com"

		//随机生成公司邮箱地址
		$companyEmail = $this->faker->companyEmail; // "yesenia.becker@gulgowski.com"

		//随机生成免费邮箱域名
		$freeEmailDomain = $this->faker->freeEmailDomain; // "hotmail.com"

		//随机生成安全邮箱域名
		$safeEmailDomain = $this->faker->safeEmailDomain; // "example.org"

		//随机生成用户名
		$userName = $this->faker->userName; // "zsatterfield"

		//随机生成密码
		$password = $this->faker->password; // "{X*6e'"

		//随机生成域名
		$domainName = $this->faker->domainName; // "dare.com"

		//随机生成域
		$domainWord = $this->faker->domainWord; // "herman"

		$tld = $this->faker->tld; // "com"

		//随机生成url地址
		$url = $this->faker->url; // "https://johnson.com/eaque-quaerat-unde-hic-laudantium-architecto-fugiat.html"

		//随机生成块
		$slug = $this->faker->slug; // "quaerat-rem-nisi-praesentium-aliquam-recusandae"

		//随机生成ipv4地址
		$ipv4 = $this->faker->ipv4; // "19.100.20.103"

		//随机生成本地ipv4地址
		$localIpv4 = $this->faker->localIpv4; // "192.168.217.59"

		//随机生成ipv6地址
		$ipv6 = $this->faker->ipv6; // "d37c:e26b:9f32:c751:e20:72f3:a7c9:b422"

		//随机生成mac地址
		$macAddress = $this->faker->macAddress; // "36:2A:2F:AF:9F:55"

		var_dump(
			$email,
			$safeEmail,
			$freeEmail,
			$companyEmail,
			$freeEmailDomain,
			$safeEmailDomain,
			$userName,
			$password,
			$domainName,
			$domainWord,
			$tld,
			$url,
			$slug,
			$ipv4,
			$localIpv4,
			$ipv6,
			$macAddress
		);
	}

	public function testUserAgent()
	{
		//用户代理
		$userAgent = $this->faker->userAgent; // 'Mozilla/5.0 (Windows CE) AppleWebKit/5350 (KHTML, like Gecko) Chrome/13.0.888.0 Safari/5350'

		//谷歌
		$chrome = $this->faker->chrome; // 'Mozilla/5.0 (Macintosh; PPC Mac OS X 10_6_5) AppleWebKit/5312 (KHTML, like Gecko) Chrome/14.0.894.0 Safari/5312'

		//火狐
		$firefox = $this->faker->firefox;  // 'Mozilla/5.0 (X11; Linuxi686; rv:7.0) Gecko/20101231 Firefox/3.6'

		//Safari
		$safari = $this->faker->safari;  // 'Mozilla/5.0 (Macintosh; U; PPC Mac OS X 10_7_1 rv:3.0; en-US) AppleWebKit/534.11.3 (KHTML, like Gecko) Version/4.0 Safari/534.11.3'

		//欧朋
		$opera = $this->faker->opera; // 'Opera/8.25 (Windows NT 5.1; en-US) Presto/2.9.188 Version/10.00'

		//ie
		$internetExplorer = $this->faker->internetExplorer; // 'Mozilla/5.0 (compatible; MSIE 7.0; Windows 98; Win 9x 4.90; Trident/3.0)'

		var_dump($userAgent, $chrome, $firefox, $safari, $opera, $internetExplorer);
	}

	public function testPayment()
	{
		//随机生成信用卡类型
		$creditCardType = $this->faker->creditCardType; // 'MasterCard'

		//随机生成信用卡号
		$creditCardNumber = $this->faker->creditCardNumber; // '4485480221084675'

		//随机生成信用卡有效日期
		$creditCardExpirationDate = $this->faker->creditCardExpirationDate; // 04/13

		//随机生成信用卡有效日期
		$creditCardExpirationDateString = $this->faker->creditCardExpirationDateString; // '04/13'

		//随机生成信用卡明细
		$creditCardDetails = $this->faker->creditCardDetails; // array('MasterCard', '4485480221084675', 'Aleksander Nowak', '04/13')

		//随机生成国际银行账号
		$iban = $this->faker->iban($countryCode = null);  // 'IT31A8497112740YZ575DJ28BP4'

		$swiftBicNumber = $this->faker->swiftBicNumber; // 'RZTIAT22263'

		var_dump($creditCardType, $creditCardNumber, $creditCardExpirationDate, $creditCardExpirationDateString, $creditCardDetails, $iban, $swiftBicNumber);
	}

	public function testColor()
	{
		//随机生成16进制颜色
		$hexColor = $this->faker->hexColor; // '#fa3cc2'

		//随机生成rgb格式的颜色
		$rgbColor = $this->faker->rgbColor; // '0,255,122'

		//随机生成数组格式的rgb颜色
		$rgbColorAsArray = $this->faker->rgbColorAsArray; // array(0,255,122)

		//随机生成css格式的rgb颜色
		$rgbCssColor = $this->faker->rgbCssColor; // 'rgb(0,255,122)'

		//随机生成颜色名称
		$safeColorName = $this->faker->safeColorName;  // 'fuchsia'
		$colorName     = $this->faker->colorName; // 'Gainsbor'

		var_dump($hexColor, $rgbColor, $rgbColorAsArray, $rgbCssColor, $safeColorName, $colorName);
	}

	public function testFile()
	{
		//随机生成文件扩展名
		$fileExtension = $this->faker->fileExtension; // 'avi'

		//随机生成mime类型
		$mimeType = $this->faker->mimeType; // 'video/x-msvideo'

		//将一个随机文件从源文件复制到目标目录，并返回fullpath或filename
		$fullPath = $this->faker->file($sourceDir = '/tmp', $targetDir = '/var'); // '/path/to/targetDir/13b73edae8443990be1aa8f1a483bc27.jpg'
		$fileName = $this->faker->file($sourceDir = '/tmp', $targetDir = '/var', false); // '13b73edae8443990be1aa8f1a483bc27.jpg'

		var_dump($fileExtension, $mimeType, $fullPath, $fileName);
	}

	public function testImage()
	{
		//随机生成图片地址
		$imageUrl = $this->faker->imageUrl($width = 640, $height = 480); //"https://lorempixel.com/640/480/?85309"
		$this->faker->imageUrl($width = 640, $height = 480, 'cats'); //"https://lorempixel.com/640/480/cats/?24879"
		$this->faker->imageUrl($width = 640, $height = 480, 'cats', true, 'Faker'); //"https://lorempixel.com/640/480/cats/Faker/?24090"
		$this->faker->imageUrl($width = 640, $height = 480, 'cats', true, 'Faker', true); //"https://lorempixel.com/gray/640/480/cats/Faker/?50629"

		//随机生成一张图片,返回图片路径
		$image = $this->faker->image($dir = '/var/www', $width = 640, $height = 480); //"/var/www/0b8e55ac992d435a2735abf15eb8259f.jpg"

		//按类型随机生成图片,返回图片地址
		$imageCats = $this->faker->image($dir = '/var/www', $width = 640, $height = 480, 'cats'); //"/var/www/2784d94db389e7a00777d15e4e28af1c.jpg"

		//按类型生成图片,不返回图片路径
		$imageNoPath = $this->faker->image($dir = '/var/www', $width = 640, $height = 480, 'cats', false); //"2784d94db389e7a00777d15e4e28af1c.jpg"

		$imageNoRandomize = $this->faker->image($dir = '/var/www', $width = 640, $height = 480, 'cats', true, false); //"/var/www/a73aa742ab5cf0be6e807268454efcd0.jpg"

		$imageFaker = $this->faker->image($dir = '/var/www', $width = 640, $height = 480, 'cats', true, true, 'Faker'); //"/var/www/b694cb5bf255fc20a78ecf6e37788246.jpg"

		var_dump($image, $imageCats, $imageNoPath, $imageNoRandomize, $imageFaker);
	}

	public function testUuid()
	{
		//随机生成一个唯一字串
		$uuid = $this->faker->uuid; // "04c975c1-48c2-3730-a4e9-139fe66ee9c0"
		var_dump($uuid);
	}

	public function testBarcode()
	{
		//随机生成13位ean码
		$ean13 = $this->faker->ean13; // '4006381333931'

		//随机生成8位ean码
		$ean8 = $this->faker->ean8; // '73513537'

		//随机生成13位isbn码
		$isbn13 = $this->faker->isbn13; // '9790404436093'

		//随机生成10位isbn码
		$isbn10 = $this->faker->isbn10; // '4881416324'

		var_dump($ean13, $ean8, $isbn13, $isbn10);
	}

	public function testMiscellaneous()
	{
		//随机生成bool值 false
		$boolean = $this->faker->boolean;

		//平衡的生成bool值
		$boolBalance = $this->faker->boolean($chanceOfGettingTrue = 50); //false

		$md5    = $this->faker->md5; // 'de99a620c50f2990e87144735cd357e7'
		$sha1   = $this->faker->sha1; // 'f08e7f04ca1a413807ebc47551a40a20a0b4de5c'
		$sha256 = $this->faker->sha256; // '0061e4c60dac5c1d82db0135a42e00c89ae3a333e7c26485321f24348c7e98a5'
		$locale = $this->faker->locale; // en_UK
		//随机生成国家编码
		$countryCode = $this->faker->countryCode; // UK

		//随机生成语言编码
		$languageCode = $this->faker->languageCode; // en

		//随机生成货币代码
		$currencyCode = $this->faker->currencyCode; // EUR
		$emoji        = $this->faker->emoji; // 😁

		var_dump($boolean, $boolBalance, $md5, $sha1, $sha256, $locale, $countryCode, $languageCode, $currencyCode, $emoji);
	}

	public function testBiased()
	{
		//在10到20之间得到一个随机数，有更多的几率接近20
		$biasedNum = $this->faker->biasedNumberBetween($min = 10, $max = 20, $function = 'sqrt'); //15

		var_dump($biasedNum);
	}

	public function testHtml()
	{
		//随机生成一个不超过 $maxDepth层的html, 任何级别上都不超过$maxWidth个元素
		$html = $this->faker->randomHtml($maxDepth = 2, $maxWidth = 3); // <html><head><title>Aut illo dolorem et accusantium eum.</title></head><body><form action="example.com" method="POST"><label for="username">sequi</label><input type="text" id="username"><label for="password">et</label><input type="password" id="password"></form><b>Id aut saepe non mollitia voluptas voluptas.</b><table><thead><tr><tr>Non consequatur.</tr><tr>Incidunt est.</tr><tr>Aut voluptatem.</tr><tr>Officia voluptas rerum quo.</tr><tr>Asperiores similique.</tr></tr></thead><tbody><tr><td>Sapiente dolorum dolorem sint laboriosam commodi qui.</td><td>Commodi nihil nesciunt eveniet quo repudiandae.</td><td>Voluptates explicabo numquam distinctio necessitatibus repellat.</td><td>Provident ut doloremque nam eum modi aspernatur.</td><td>Iusto inventore.</td></tr><tr><td>Animi nihil ratione id mollitia libero ipsa quia tempore.</td><td>Velit est officia et aut tenetur dolorem sed mollitia expedita.</td><td>Modi modi repudiandae pariatur voluptas rerum ea incidunt non molestiae eligendi eos deleniti.</td><td>Exercitationem voluptatibus dolor est iste quod molestiae.</td><td>Quia reiciendis.</td></tr><tr><td>Inventore impedit exercitationem voluptatibus rerum cupiditate.</td><td>Qui.</td><td>Aliquam.</td><td>Autem nihil aut et.</td><td>Dolor ut quia error.</td></tr><tr><td>Enim facilis iusto earum et minus rerum assumenda quis quia.</td><td>Reprehenderit ut sapiente occaecati voluptatum dolor voluptatem vitae qui velit.</td><td>Quod fugiat non.</td><td>Sunt nobis totam mollitia sed nesciunt est deleniti cumque.</td><td>Repudiandae quo.</td></tr><tr><td>Modi dicta libero quisquam doloremque qui autem.</td><td>Voluptatem aliquid saepe laudantium facere eos sunt dolor.</td><td>Est eos quis laboriosam officia expedita repellendus quia natus.</td><td>Et neque delectus quod fugit enim repudiandae qui.</td><td>Fugit soluta sit facilis facere repellat culpa magni voluptatem maiores tempora.</td></tr><tr><td>Enim dolores doloremque.</td><td>Assumenda voluptatem eum perferendis exercitationem.</td><td>Quasi in fugit deserunt ea perferendis sunt nemo consequatur dolorum soluta.</td><td>Maxime repellat qui numquam voluptatem est modi.</td><td>Alias rerum rerum hic hic eveniet.</td></tr><tr><td>Tempore voluptatem.</td><td>Eaque.</td><td>Et sit quas fugit iusto.</td><td>Nemo nihil rerum dignissimos et esse.</td><td>Repudiandae ipsum numquam.</td></tr><tr><td>Nemo sunt quia.</td><td>Sint tempore est neque ducimus harum sed.</td><td>Dicta placeat atque libero nihil.</td><td>Et qui aperiam temporibus facilis eum.</td><td>Ut dolores qui enim et maiores nesciunt.</td></tr><tr><td>Dolorum totam sint debitis saepe laborum.</td><td>Quidem corrupti ea.</td><td>Cum voluptas quod.</td><td>Possimus consequatur quasi dolorem ut et.</td><td>Et velit non hic labore repudiandae quis.</td></tr></tbody></table></body></html>

		var_dump($html);
	}

	public function testModifiers()
	{
		//unique() 强制返回一个唯一的值
		try {
			for ($i = 0; $i < 10; $i++) {
				$values[] = $this->faker->unique($reset = false)->randomDigit;
			}
		} catch (OverflowException $e) {
			echo "can't generate unique number";
		}

		var_dump($values);

		//optional() 接受一个权重参数来指定接收默认值的概率
		$digit = $this->faker->optional($weight = 0.1)->randomDigit; // 90% chance of NULL
		var_dump($digit);
	}
}