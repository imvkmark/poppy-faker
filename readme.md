# Poppy\Faker

Poppy Faker 是基于 [fzaninotto/Faker](https://github.com/fzaninotto/Faker) 的中文版本, 因为之前的版本包含语言过多, 所以将这个数据进行拆离, 并加入中国特色的部分验证规则. 

Faker 可以帮助你创建数据库数据, XML 报表, 填写假地址, 或者匿名的数据. 


## 安装

```sh
composer require poppy/faker
```

## 基本使用

在项目根目录下运行 

```
$ php -S 0.0.0.0:8000 -t tests/
PHP 7.2.33 Development Server started at Thu Nov  5 15:21:19 2020
Listening on http://0.0.0.0:8000
Document root is /path/of/poppy/faker/tests
Press Ctrl-C to quit.
```

然后再浏览器访问即可获取详细的示例数据

```
http://127.0.0.1:8000/       # 返回 带有样式的示例数据
http://127.0.0.1:8000/?md    # 返回 Markdown 格式数据
```


## 基于包的调整项目
- 删除 ORM
- 删除除 [en_US, zh_CN, zh_TW] , 之外的语言
- 增加 zhCN 身份证号生成


## 创建假数据

使用 `\Poppy\Faker\Factory::create('zh_CN')` 来创建和初始化生成器, 这里保留之前英文版生成数据的规则

```php
<?php
// use the factory to create a \Poppy\Faker\Generator instance
$faker = \Poppy\Faker\Factory::create('zh_CN');

// generate data by accessing properties
echo $faker->name;
  // 'Lucy Cechtelar';
echo $faker->address;
  // "426 Jordy Lodge
  // Cartwrightshire, SC 88120-6700"
echo $faker->text;
  // Dolores sit sint laboriosam dolorem culpa et autem. Beatae nam sunt fugit
  // et sit et mollitia sed.
  // Fuga deserunt tempora facere magni omnis. Omnis quia temporibus laudantium
  // sit minima sint.
```




### Base

```
// 生成随机整数 0 - 9
$faker->randomDigit;                                  // 8
// 生成唯一整数
$faker->unique()->randomDigit;                        // 1
// 生成随机不为空的整数
$faker->randomDigitNotNull;                           // 8
// 生成随机数字
$faker->randomNumber($nbDigits = 5, $strict = false); // 6783
// 生成随机浮点数
$faker->randomFloat($nbMaxDecimals = null, $min = 0, $max = null); // 13399.11050914
// 在指定范围内生成随机数
$faker->numberBetween($min = 1000, $max = 9000);      // 3953
// 生成随机字符
$faker->randomLetter;                                 // t
// 在给定的数组中,随机生成给定的个数字符
$faker->randomElements($array = ['a', 'b', 'c'], $count = 2); // Array
(
    [0] => a
    [1] => c
)

// 在给定的数组中,生成单个随机字符
$faker->randomElement($array = ['a', 'b', 'c']);      // a
// 打乱给定的字符串
$faker->shuffle('hello, world');                      // elrlh dowol,
// 打乱给定的数组
$faker->shuffle([1, 2, 3]);                           // Array
(
    [0] => 3
    [1] => 1
    [2] => 2
)

// 给占位符生成随机整数 (数字为#)
$faker->numerify('Hello ###');                        // Hello 713
// 给占位符生成随机字符串 (字符串为?)
$faker->lexify('Hello ???');                          // Hello jjg
// 给占位符生成混合的随机字符串
$faker->bothify('Hello ##??');                        // Hello 79ks
// 给占位符生成随机的字符(字母、数字、符号)
$faker->asciify('Hello ***');                         // Hello B.7
// 根据正则规则生成随机字符
$faker->regexify('[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}'); // _XD%HRE@VUREXV2D.OLYE
```


### Lorem

```
// 生成随机个数的字符串
$faker->word;                                         // 议
// 随机生成指定个数的字符串
$faker->words($nb = 3, $asText = false);              // Array
(
    [0] => 玩
    [1] => 转
    [2] => 答
)

// 随机生成一条语句
$faker->sentence($nbWords = 6, $variableNbWords = true); // 纳怀房海交知.
// 随机生成指定条数的语句
$faker->sentences($nb = 3, $asText = false);          // Array
(
    [0] => 授界类表如守.
    [1] => 尼痛念化人归懂总.
    [2] => 圣味送杂含贝机四.
)

// 随机生成一个段落
$faker->paragraph($nbSentences = 3, $variableNbSentences = true); // 雄摇马史她戴袋. 层关飞某阿喊. 松上助仍奥外讲.
// 随机生成指定个数段落
$faker->paragraphs($nb = 3, $asText = false);         // Array
(
    [0] => 充条数和制尔进知中. 果藏供创阵急遗然. 从请生反雄仍洲叶护.
    [1] => 报停暗险端市. 兴定北洛革. 去夜慢纳脚脱. 调雪妙托脱走它相. 汉典儿九刻.
    [2] => 真语强究授童剧银. 型济著武热吧克藏. 母英封蒙.
)

// 随机生成一个文本
$faker->text($maxNbChars = 200);                      // 熟称喝救告吸确. 馆推布信久识. 民又事黄要之怎划. 奇兰现介先对戏. 罪总乎论雪兵黄岛. 禁安议做亲差学极.
```


### Person

```
// 职位
$faker->title;             // 太太
// 称谓
$faker->titleMale;         // 教授
// 女性称谓
$faker->titleFemale;       // 律师
// 姓名
$faker->name               // 萧文君
// 名字
$faker->firstName          // 志明
// 男性名字
$faker->firstNameMale      // 华
// 女性名字
$faker->firstNameFemale    // 楠
// 姓
$faker->lastName           // 马
// 随机生成一个可以校验的身份证号
$faker->idNumber           // 640181200809108307
```


### Address

```
// 随机生成省份/州
$faker->state;                                 // 河南省
// 随机城市省份/州缩写
$faker->stateAbbr;                             // 蒙
// 随机生成城市后缀
$faker->citySuffix;                            // Ville
// 随机生成街道后缀
$faker->streetSuffix;                          // Street
// 随机生成建筑编号
$faker->buildingNumber;                        // 11
// 随机生成城市
$faker->city;                                  // 拉萨
// 随机生成街道名
$faker->streetName;                            // 畅 Street
// 随机生成街道地址
$faker->streetAddress;                         // 71 孟 Street
// 随机生成邮编
$faker->postcode;                              // 217000
// 随机生成地址
$faker->address;                               // 沈阳兴山区
// 随机生成国家
$faker->country;                               // 圣马力诺
// 随机生成纬度
$faker->latitude($min = -90, $max = 90);       // 75.15737
// 随机生成经度
$faker->longitude($min = -180, $max = 180);    // -81.385411
```


### Phone Number

```
// 生成随机电话号码
$faker->phoneNumber;        // 13273265620
// 随机生成e164电话
$faker->e164PhoneNumber;    // +3411056457052
```


### Company

```
// 随机生成公司
$faker->company;          // 巨奥信息有限公司
// 随机生成公司后缀
$faker->companySuffix;    // 传媒有限公司
// 随机生成职务
$faker->jobTitle;         // 必
```


### Text

```
// 随机生成一段文本
$faker->realText($maxNbChars = 200, $indexSize = 2);  // CHAPTER IV. The Rabbit Sends in a deep, hollow tone: 'sit down, both of you, and don't speak a word till I've finished.' So they had to pinch it to make out exactly what they WILL do next! If they.
```


### Datetime

```
// 随机生成时间戳
$faker->unixTime($max = 'now');                       // 84146285
// 随机生成时间
$faker->dateTime($max = 'now', $timezone = date_default_timezone_get()); // DateTime Object
(
    [date] => 1981-09-02 21:14:42.000000
    [timezone_type] => 3
    [timezone] => Asia/Shanghai
)

//  dateTimeAd
$faker->dateTimeAD;                                   // DateTime Object
(
    [date] => 0308-03-16 05:39:50.000000
    [timezone_type] => 3
    [timezone] => Asia/Shanghai
)

// 随机生成ios8601时间
$faker->iso8601($max = 'now');                        // 1991-03-04T20:59:46+0800
// 根据格式随机生成日期
$faker->date($format = 'Y-m-d', $max = 'now');        // 1983-03-01
// 根据格式随机生成时间
$faker->time($format = 'H:i:s', $max = 'now');        // 22:34:27
// 生成指定范围的时间
$faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now'); // DateTime Object
(
    [date] => 2006-07-12 13:47:24.000000
    [timezone_type] => 3
    [timezone] => Asia/Shanghai
)

// 随机生成一个指定间隔的时间
$faker->dateTimeInInterval($startDate = '-30 years', $interval = '+ 5 days', $timezone = date_default_timezone_get()); // DateTime Object
(
    [date] => 1990-11-08 17:13:04.000000
    [timezone_type] => 3
    [timezone] => Asia/Shanghai
)

// 随机生成当前世纪的时间
$faker->dateTimeThisCentury($max = 'now', $timezone = date_default_timezone_get()); // DateTime Object
(
    [date] => 1991-02-19 01:39:03.000000
    [timezone_type] => 3
    [timezone] => Asia/Shanghai
)

// 随机生成当前十年的时间
$faker->dateTimeThisDecade($max = 'now', $timezone = date_default_timezone_get()); // DateTime Object
(
    [date] => 2013-12-25 22:46:17.000000
    [timezone_type] => 3
    [timezone] => Asia/Shanghai
)

// 随机生成当前年的时间
$faker->dateTimeThisYear($max = 'now', $timezone = date_default_timezone_get()); // DateTime Object
(
    [date] => 2020-05-18 23:34:51.000000
    [timezone_type] => 3
    [timezone] => Asia/Shanghai
)

// 随机生成当前月的时间
$faker->dateTimeThisMonth($max = 'now', $timezone = date_default_timezone_get()); // DateTime Object
(
    [date] => 2020-10-27 04:22:07.000000
    [timezone_type] => 3
    [timezone] => Asia/Shanghai
)

// 随机生成 am/pm
$faker->amPm($max = 'now');                           // 下午
// 随机生成月份的某一天
$faker->dayOfMonth($max = 'now');                     // 30
// 随机生成星期
$faker->dayOfWeek($max = 'now');                      // 星期日
// 随机生成月份
$faker->month($max = 'now');                          // 03
// 随机生成月份的名称
$faker->monthName($max = 'now');                      // 十一月
// 随机生成年份
$faker->year($max = 'now');                           // 2004
// 随机生成世纪
$faker->century;                                      // XV
// 随机生成时区
$faker->timezone;                                     // Asia/Hebron
```


### Internet

```
// 随机生成邮箱地址
$faker->email;              // xiao_er@hotmail.com
// 随机生成安全的邮箱地址
$faker->safeEmail;          // an82@example.net
// 随机生成免费的邮箱地址
$faker->freeEmail;          // alian@126.com
// 随机生成公司邮箱地址
$faker->companyEmail;       // tong_mai@qu.com
// 随机生成免费邮箱域名
$faker->freeEmailDomain;    // 126.com
// 随机生成安全邮箱域名
$faker->safeEmailDomain;    // example.org
// 随机生成用户名
$faker->userName;           // ting_du
// 随机生成密码
$faker->password;           // h1RZMuV54|n=Q$L-in]
// 随机生成域名
$faker->domainName;         // yan.org
// 随机生成域
$faker->domainWord;         // bai
// todo Tld
$faker->tld;                // biz
// 随机生成url地址
$faker->url;                // https://zhou.info/方-农-死-规.html
// 随机生成块
$faker->slug;               // 的-城-心-古-终-参-济-文
// 随机生成ipv4地址
$faker->ipv4;               // 243.54.13.136
// 随机生成本地ipv4地址
$faker->localIpv4;          // 10.5.211.82
// 随机生成ipv6地址
$faker->ipv6;               // 7ca1:9d43:46d5:589f:1b2b:e372:5e17:1a91
// 随机生成mac地址
$faker->macAddress;         // 14:38:9C:55:CD:C5
```


### UserAgent

```
// 用户代理
$faker->userAgent;           // Mozilla/5.0 (X11; Linux x86_64; rv:6.0) Gecko/20190828 Firefox/36.0
// 谷歌
$faker->chrome;              // Mozilla/5.0 (Windows 98; Win 9x 4.90) AppleWebKit/5321 (KHTML, like Gecko) Chrome/37.0.885.0 Mobile Safari/5321
// 火狐
$faker->firefox;             // Mozilla/5.0 (Windows NT 5.1; en-US; rv:1.9.2.20) Gecko/20110217 Firefox/36.0
// Safari
$faker->safari;              // Mozilla/5.0 (iPad; CPU OS 7_0_1 like Mac OS X; en-US) AppleWebKit/531.7.5 (KHTML, like Gecko) Version/3.0.5 Mobile/8B111 Safari/6531.7.5
// 欧朋
$faker->opera;               // Opera/8.83 (Windows NT 5.01; en-US) Presto/2.12.189 Version/12.00
// ie
$faker->internetExplorer;    // Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/3.1)
```


### Payment

```
// 随机生成信用卡类型
$faker->creditCardType;                    // MasterCard
// 随机生成信用卡号
$faker->creditCardNumber;                  // 343611837373950
// 随机生成信用卡有效日期
$faker->creditCardExpirationDate;          // DateTime Object
(
    [date] => 2022-11-09 16:46:16.000000
    [timezone_type] => 3
    [timezone] => Asia/Shanghai
)

// 随机生成信用卡有效日期
$faker->creditCardExpirationDateString;    // 11/20
// 随机生成信用卡明细
$faker->creditCardDetails;                 // Array
(
    [type] => Visa
    [number] => 4556837981031508
    [name] => 鄢子安
    [expirationDate] => 06/21
)

// 随机生成国际银行账号
$faker->iban($countryCode = null);         // GR8189640507T689358O3SK6K5B
// todo 瑞士银行账号
$faker->swiftBicNumber;                    // DWDFOKO4S3Y
```


### Color

```
// 随机生成16进制颜色
$faker->hexColor;           // #7675e0
// 随机生成rgb格式的颜色
$faker->rgbColor;           // 222,237,164
// 随机生成数组格式的rgb颜色
$faker->rgbColorAsArray;    // Array
(
    [0] => 118
    [1] => 160
    [2] => 37
)

// 随机生成css格式的rgb颜色
$faker->rgbCssColor;        // rgb(133,60,133)
// 随机生成颜色名称
$faker->safeColorName;      // 黑色
//  颜色名称
$faker->colorName;          // 暗兰紫
```


### File

```
// 随机生成文件扩展名
$faker->fileExtension;    // 3dml
// 随机生成mime类型
$faker->mimeType;         // application/vnd.pvi.ptid1
```


### Image

```
// 随机生成图片地址
$faker->imageUrl($width = 640, $height = 480); // https://fakeimg.pl/640x480/282828/eae0d0?
// 随机生成头像地址
$faker->avatarUrl(300, 'girl');                // https://i.pravatar.cc/300?img=10
// 返回 Svg Url 地址
$faker->svgUrl(100, 100)                       // https://avatars.dicebear.com/api/bottts/19943.svg?width=100&height=100
```


### UUID

```
// 随机生成一个唯一字串
$faker->uuid    // 47b5b18c-6fee-3188-9d88-ecb7e406da4b
```


### Calculator

```
// 随机生成13位ean码
$faker->ean13;     // 0120309434624
// 随机生成8位ean码
$faker->ean8;      // 44845025
// 随机生成13位isbn码
$faker->isbn13;    // 9798976904019
// 随机生成10位isbn码
$faker->isbn10;    // 7300501559
```


### Miscellaneous

```
// 随机生成bool值 false
$faker->boolean;                               // 1
// 平衡的生成bool值
$faker->boolean($chanceOfGettingTrue = 50);    // 
//  Md5
$faker->md5;                                   // 02ab746139e35599e12a2a0fc21ece2c
//  Sha1
$faker->sha1;                                  // 81308895610bbe530dec6269e4cce55044dda0dd
//  Sha256
$faker->sha256;                                // 3cc0882a1c3d7f68298a93c32ce2f094118ad72dbe00ef35e96f4613aaecef2f
//  Locale
$faker->locale;                                // ja_JP
// 随机生成国家编码
$faker->countryCode;                           // IS
// 随机生成语言编码
$faker->languageCode;                          // mn
// 随机生成货币代码
$faker->currencyCode;                          // KZT
//  Emoji
$faker->emoji;                                 // 😞
```


### Biased

```
// 在10到20之间得到一个随机数，有更多的几率接近20
$faker->biasedNumberBetween($min = 10, $max = 20, $function = 'sqrt'); // 17
```


### Html

```
// 随机生成一个不超过 $maxDepth层的html, 任何级别上都不超过$maxWidth个元素
$faker->randomHtml($maxDepth = 2, $maxWidth = 3);    // <html><head><title>&#35328;&#33410;&#26174;&#30331;.</title></head><body><form action="example.com" method="POST"><label for="username">&#21017;</label><input type="text" id="username"><label for="password">&#38750;</label><input type="password" id="password"></form><i>&#27700;&#32447;&#21517;&#35785;&#21568;&#23396;&#36215;.</i></body></html>

```


## License

Faker is released under the MIT License. See the bundled LICENSE file for details.
