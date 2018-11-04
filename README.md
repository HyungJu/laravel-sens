# 라라벨 네이버 클라우드 플랫폼 SENS SMS 전송 채널
code based on https://github.com/laravel-notification-channels/telegram 
## Contents

- [Installation](#installation)
	- [Setting up your Telegram bot](#setting-up-your-telegram-bot)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Alternatives](#alternatives)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Installation

You can install the package via composer:

``` bash
composer require hyungju/laravel-sens
```

You must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    NotificationChannels\Sens\SensServiceProvider::class,
],
```

## 토큰 세팅하기

https://sens.ncloud.com/assets/html/docs/index.html?url=https://api-sens.ncloud.com/docs/openapi/ko

여기 SMS발송 POST를 참고해서 세팅해주세요.

```php
// config/services.php
...
    'sens' => [
        'x-ncp-auth-key' => env('sens.x-ncp-auth-key'),
        'x-ncp-service-secret' => env('sens.x-ncp-service-secret'),
        'serviceid' => env('sens.serviceid'),
    ],
...
```

하신후에 .env에서도 
```
sens.x-ncp-auth-key="KEY"
sens.x-ncp-service-secret="KEY"
sens.serviceid="KEY"
```

설정해주세요
## Usage

You can now use the channel in your `via()` method inside the Notification class.

``` php
use NotificationChannels\Sens\SensChannel;
use NotificationChannels\Sens\SensMessage;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification
{
    public function via($notifiable)
    {
        return [SensChannel::class];
    }


    public function toSens($notifiable)
    {
        return SensMessage::create()
            ->content("[라라벨 NCP Sens Notification Channel TEST]\n라라벨의 네이버 클라우드 플랫폼 SENS 채널 테스트입니다. 이 문자는 ".$notifiable->name." 유저에게 발송되었습니다.")->countrycode("82")->forcommon()->tolms()->subject("LMS로 전송")->to($notifiable->phone)->from("등록된 발신자번호");
    } 
}
```

     

### Routing a message

You can either send the notification by providing with the chat id of the recipient to the `to($chatId)` method like shown in the above example or add a `routeNotificationForTelegram()` method in your notifiable model:

``` php
...
/**
 * Route notifications for the Telegram channel.
 *
 * @return int
 */
public function routeNotificationForTelegram()
{
    return $this->telegram_user_id;
}
...
```
[TODO] 곧 구현


### Available Message methods

[TODO] 곧 가독성있게 정리

 * to
 * from
 * tosms
 * tolms
* forad
* forcommon
* countrycode
* content
* subject

SensMessage.php를 참고하여 작업 부탁드립니다

조만간 다시 정리해오겠습니다



## Security

If you discover any security related issues, please email syed@lukonet.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits
- [성형주](https://github.com/hyungju) - Modified telegram channel for ncp sens sms

- [Syed Irfaq R.](https://github.com/irazasyed) - Original Telegram Channel

- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
