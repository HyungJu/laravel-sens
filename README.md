# Laravel Sens

라라벨용 [NCP](https://www.ncloud.com/) SENS SMS 전송 채널.



## 목차

- 설치
- 토큰 설정
- 사용
- 기여
- Credits



## 설치

Laravel Sens는 Composer 저장소에서 다운로드 가능합니다.

라라벨 프로젝트 루트에서 다음 명령을 입력하여 설치할 수 있습니다.

```bash
composer require hyungju/laravel-sens
```



설치 후, 본 채널을 등록하여야 합니다.

`config/app.php`에서 다음 코드를 입력하십시오.

```php
'providers' => [
    ...
    NotificationChannels\Sens\SensServiceProvider::class,
],
```



## 토큰 설정

NCP에서는 토큰을 통해 사용자를 인증하여 SMS를 전송합니다.

**Laravel Sens**는 총 3개의 토큰을 필요로 합니다.

- x-ncp-auth-key
- x-ncp-service-secret
- serviceid

[NCP](https://www.ncloud.com/)에서 해당 토큰들을 발급한 후에, 

`config/services.php` 에서

```php
...
    'sens' => [
        'x-ncp-auth-key' => env('SENS_AUTH_KEY'),
        'x-ncp-service-secret' => env('SENS_AUTH_SECRET'),
        'serviceid' => env('SENS_SERVICE_ID'),
        'from' => env('SENS_DEFAULT_FROM'),
    ],
...
```

다음과 같은 코드를 추가한 후, 

**라라벨 프로젝트 루트**의 `.env `파일에 

```
SENS_AUTH_KEY=key
SENS_AUTH_SECRET=key
SENS_SERVICE_ID=key
SENS_DEFAULT_FROM=key
```

다음과같은 내용을 입력하면 됩니다.



## 사용

Notification Class에서 이제, **Laravel Sens**를 이용할 수 있습니다.

```php
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
            ->content("[라라벨 NCP Sens Notification Channel TEST]\n라라벨의 네이버 클라우드 플랫폼 SENS 채널 테스트입니다. 이 문자는 ".$notifiable->name." 유저에게 발송되었습니다.")
            ->countryCode("82")
            ->forCommon()
            ->toLMS()
            ->subject("LMS로 전송")
            ->to($notifiable->phone)
            ->from("등록된 발신자번호");
    } 
}
```



Laravel SENS에서는 다음과같은 SMS 전송 메소드들을 제공합니다.

.env 파일에서 SENS_DEFAULT_FROM 를 설정 하였다면 from 을 생략하여도 됩니다. 

- `to` : 수신자 전화번호 설정
- `content` : SMS 내용
- `from` : 발신자 번호 설정 **사전에 NCP SENS에 등록한 번호만 전송이 가능합니다 **
- `tosms` : SMS로 전송. 
- `tolms` : LMS로 전송. 
- `forad` : 광고용 메시지 전송
- `forcommon` : 일반 메시지 전송
- `countrycode` : 국가번호 입력
- `subject` : LMS인경우, 제목






## License

The MIT License (MIT). Please see [License File](https://github.com/HyungJu/laravel-sens/blob/master/LICENSE.md) for more information.
