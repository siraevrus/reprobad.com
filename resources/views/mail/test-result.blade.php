<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns="http://www.w3.org/1999/xhtml" lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="format-detection" content="telephone=no">
  <title>Система РЕПРО: Результаты теста «Репродуктивное здоровье»</title>
  <style type="text/css">
    #outlook a { padding: 0; }
    .ExternalClass { width: 100%; }
    .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
    body, table, td, p, a, li, blockquote { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
    table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
    img { -ms-interpolation-mode: bicubic; border: 0; line-height: 100%; outline: none; text-decoration: none; }
    a[x-apple-data-detectors] { color: inherit !important; text-decoration: none !important; font-size: inherit !important; font-family: inherit !important; font-weight: inherit !important; line-height: inherit !important; }
    body { margin: 0 !important; padding: 0 !important; width: 100% !important; background-color: #ffffff; }
    .email-wrapper { width: 100%; background-color: #ffffff; }
    .email-container { width: 600px; max-width: 600px; }
    a { color: #1376C8; text-decoration: underline; }
    p { margin: 0; }
    h1, h2, h3, h4, h5 { margin: 0; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; color: #333333; }
    @media only screen and (max-width: 620px) {
      .email-container { width: 100% !important; max-width: 100% !important; }
      .responsive-img { width: 100% !important; height: auto !important; }
      .hero-cell { display: block !important; width: 100% !important; padding: 0 !important; }
      .hero-cell--right { padding-top: 16px !important; }
      .block-icon-cell { width: 60px !important; }
      .block-percent { font-size: 22px !important; }
      .adv-cell { display: block !important; width: 100% !important; padding: 0 0 18px 0 !important; }
      .adv-cell--last { padding-bottom: 0 !important; }
    }
  </style>
</head>
<body style="margin:0;padding:0;width:100%;background-color:#ffffff;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;">
@php
  $blocks = isset($r['blocks']) && is_array($r['blocks']) ? $r['blocks'] : [];
  $blockTitles = (array) (config('repro_test.block_titles') ?? []);
  $blockAllClearTitles = (array) (config('repro_test.block_all_clear_titles') ?? []);
  $blockCss = (array) (config('repro_test.block_css') ?? []);
  $blockIconsEmail = (array) (config('repro_test.block_icons_email') ?? []);
  $blockIcons = (array) (config('repro_test.block_icons') ?? []);
  $mailBase = trim((string) (config('repro_test.mail_asset_base_url') ?? ''));
  $mailBase = $mailBase !== '' ? rtrim($mailBase, '/') : '';

  $cssColors = [
      'psih' => ['fill' => '#4e8eaa', 'text' => '#4e8eaa'],
      'energy' => ['fill' => '#ff967b', 'text' => '#ff967b'],
      'meta' => ['fill' => '#839f6a', 'text' => '#839f6a'],
      'gorm' => ['fill' => '#9f99de', 'text' => '#9f99de'],
  ];

  $imgUrl = static function (?string $path) use ($mailBase): string {
      if (! $path) { return ''; }
      if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) { return $path; }
      $path = ltrim($path, '/');
      return $mailBase !== '' ? $mailBase.'/'.$path : url($path);
  };
@endphp

<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" class="email-wrapper" style="background-color:#ffffff;">
  <tr>
    <td align="center" style="padding:0;">
      <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" class="email-container" style="width:600px;max-width:600px;">

        <tr>
          <td align="center" style="padding:20px 20px 10px 20px;">
            <img src="{{ $imgUrl('storage/email/result/logo.png') }}" alt="Система РЕПРО" width="525" height="63" class="responsive-img" style="display:block;border:0;outline:none;text-decoration:none;max-width:100%;height:auto;">
          </td>
        </tr>

        <tr>
          <td style="padding:0 20px;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" bgcolor="#e8f4fb" style="background-color:#e8f4fb;border-radius:16px;">
              <tr>
                <td style="padding:24px;">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                      <td class="hero-cell" valign="top" style="width:55%;padding-right:16px;">
                        <h1 style="margin:0 0 12px 0;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:22px;line-height:28px;color:#1a1a1a;font-weight:700;">Ваши персональные результаты</h1>
                        @if($hasRecommendations)
                          <p style="margin:0;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:14px;line-height:20px;color:#333333;">Мы проанализировали ваши ответы в&nbsp;тесте «Репродуктивное здоровье». Вот&nbsp;что происходит с&nbsp;вашим организмом, на что важно обратить внимание и&nbsp;какие шаги мы рекомендуем для&nbsp;улучшения вашего самочувствия.</p>
                        @else
                          <p style="margin:0;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:14px;line-height:20px;color:#333333;">Ваши результаты на&nbsp;высоте, это говорит о&nbsp;вашем внимании к&nbsp;себе и&nbsp;отличных привычках. Продолжайте в&nbsp;том же духе: поддерживайте баланс, прислушивайтесь к&nbsp;своему организму и&nbsp;не забывайте о&nbsp;поддержке.</p>
                        @endif
                      </td>
                      <td class="hero-cell hero-cell--right" valign="middle" align="center" style="width:45%;">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                          <tr>
                            <td align="center" style="font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:32px;line-height:36px;font-weight:700;color:#1a1a1a;padding:4px 0 0 0;">
                              {{ (int) $ibhb }}%
                            </td>
                          </tr>
                          <tr>
                            <td align="center" style="font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:12px;line-height:16px;color:#333333;padding:4px 0 0 0;">
                              индекс биоэнергетического<br>и&nbsp;гормонального баланса
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <tr><td style="height:16px;line-height:16px;font-size:0;">&nbsp;</td></tr>

        @for ($bn = 1; $bn <= 4; $bn++)
          @php
            $block = is_array($blocks[$bn] ?? null) ? $blocks[$bn] : (is_array($blocks[(string) $bn] ?? null) ? $blocks[(string) $bn] : []);
            $bcss = (string) ($block['css'] ?? ($blockCss[$bn] ?? 'psih'));
            $paragraphs = isset($block['paragraphs']) && is_array($block['paragraphs']) ? $block['paragraphs'] : [];
            $fields = isset($block['fields']) && is_array($block['fields']) ? $block['fields'] : [];
            $hasPersonalText = count($paragraphs) > 0;
            if (! $hasPersonalText) {
                foreach ($fields as $fld) {
                    $pd = trim((string) ($fld['description'] ?? ''));
                    $pe = trim((string) ($fld['email_description'] ?? ''));
                    if ($pd !== '' || $pe !== '') { $hasPersonalText = true; break; }
                }
            }

            $idx = (int) ($block['idx'] ?? 0);
            if ($hasRecommendations) {
                $title = trim((string) ($block['title'] ?? '')) ?: (string) ($blockTitles[$bn] ?? '');
            } else {
                $title = trim((string) ($blockAllClearTitles[$bn] ?? '')) ?: (string) ($blockTitles[$bn] ?? '');
            }
            $clearPhrase = ! $hasPersonalText
                ? trim((string) (\Illuminate\Support\Arr::get($allClearPhrases, $bn, \Illuminate\Support\Arr::get($allClearPhrases, (string) $bn, ''))))
                : '';
            $colors = $cssColors[$bcss] ?? $cssColors['psih'];
            $iconPath = $blockIconsEmail[$bn] ?? ($blockIconsEmail[(string) $bn] ?? ($blockIcons[$bn] ?? ($blockIcons[(string) $bn] ?? null)));
            $iconUrl = $imgUrl($iconPath);
            $barWidth = max(1, min(100, $idx));
          @endphp

          <tr>
            <td style="padding:0 20px 16px 20px;">
              <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" bgcolor="#ffffff" style="background-color:#ffffff;border:1px solid #ecf2f7;border-radius:16px;">
                <tr>
                  <td style="padding:20px;">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                      <tr>
                        @if($iconUrl !== '')
                        <td class="block-icon-cell" valign="top" style="width:80px;padding-right:16px;">
                          <img src="{{ $iconUrl }}" alt="" width="64" height="64" style="display:block;border:0;outline:none;text-decoration:none;width:64px;height:64px;">
                        </td>
                        @endif
                        <td valign="top">
                          <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                              <td valign="middle" style="font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:16px;line-height:20px;font-weight:700;color:#1a1a1a;padding-right:8px;">
                                {{ $title }}
                              </td>
                              <td valign="middle" align="right" class="block-percent" style="font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:24px;line-height:24px;font-weight:700;color:{{ $colors['text'] }};white-space:nowrap;">
                                {{ (int) $idx }}%
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2" style="padding-top:10px;">
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" bgcolor="#eef5fa" style="background-color:#eef5fa;border-radius:8px;">
                                  <tr>
                                    <td style="font-size:0;line-height:0;height:10px;padding:0;">
                                      <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="{{ $barWidth }}%" style="width:{{ $barWidth }}%;">
                                        <tr>
                                          <td bgcolor="{{ $colors['fill'] }}" style="background-color:{{ $colors['fill'] }};height:10px;line-height:10px;font-size:0;border-radius:8px;">&nbsp;</td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>

                    @if($hasPersonalText)
                      @if(count($fields) > 0)
                        @foreach($fields as $fldIndex => $fld)
                          @php
                            $emailHtml = trim((string) ($fld['email_description'] ?? ''));
                            $shortHtml = trim((string) ($fld['description'] ?? ''));
                            $paraHtml = $emailHtml !== '' ? $emailHtml : $shortHtml;
                            $isPreformattedHtml = $paraHtml !== '' && str_contains($paraHtml, '<');
                            $img1 = trim((string) ($fld['image1'] ?? ''));
                            $img2 = trim((string) ($fld['image2'] ?? ''));
                            $link1 = trim((string) ($fld['link1'] ?? ''));
                            $link2 = trim((string) ($fld['link2'] ?? ''));
                            $img1Url = $img1 !== '' ? $imgUrl($img1) : '';
                            $img2Url = $img2 !== '' ? $imgUrl($img2) : '';
                            $hasImages = $img1Url !== '' || $img2Url !== '';
                          @endphp
                          @if($paraHtml !== '' || $hasImages)
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top:14px;">
                              @if($paraHtml !== '')
                              <tr>
                                <td style="font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:14px;line-height:21px;color:#333333;">
                                  @if($isPreformattedHtml)
                                    {!! $paraHtml !!}
                                  @else
                                    {!! nl2br(e($paraHtml)) !!}
                                  @endif
                                </td>
                              </tr>
                              @endif
                              @if($hasImages)
                                <tr>
                                  <td style="padding-top:14px;">
                                    <!--[if mso]><table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"><tr><td valign="top" style="width:50%;padding-right:6px;"><![endif]-->
                                    @if($img1Url !== '')
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="left" width="48%" style="width:48%;mso-hide:all;">
                                      <tr>
                                        <td align="center" style="padding:0;">
                                          @if($link1 !== '')
                                          <a href="{{ $link1 }}" target="_blank" style="text-decoration:none;display:block;">
                                          @endif
                                            <img src="{{ $img1Url }}" alt="" width="225" class="responsive-img" style="display:block;border:0;outline:none;text-decoration:none;max-width:100%;height:auto;border-radius:12px;">
                                          @if($link1 !== '')
                                          </a>
                                          @endif
                                        </td>
                                      </tr>
                                    </table>
                                    @endif
                                    <!--[if mso]></td><td valign="top" style="width:50%;padding-left:6px;"><![endif]-->
                                    @if($img2Url !== '')
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="right" width="48%" style="width:48%;mso-hide:all;">
                                      <tr>
                                        <td align="center" style="padding:0;">
                                          @if($link2 !== '')
                                          <a href="{{ $link2 }}" target="_blank" style="text-decoration:none;display:block;">
                                          @endif
                                            <img src="{{ $img2Url }}" alt="" width="225" class="responsive-img" style="display:block;border:0;outline:none;text-decoration:none;max-width:100%;height:auto;border-radius:12px;">
                                          @if($link2 !== '')
                                          </a>
                                          @endif
                                        </td>
                                      </tr>
                                    </table>
                                    @endif
                                    <!--[if mso]></td></tr></table><![endif]-->
                                    <div style="clear:both;font-size:0;line-height:0;">&nbsp;</div>
                                  </td>
                                </tr>
                              @endif
                            </table>
                          @endif
                        @endforeach
                      @elseif(count($paragraphs) > 0)
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top:14px;">
                          <tr>
                            <td style="font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:14px;line-height:21px;color:#333333;">
                              @foreach($paragraphs as $para)
                                @php $para = trim((string) $para); @endphp
                                @if($para !== '')
                                  <div style="margin:0 0 10px 0;">{!! $para !!}</div>
                                @endif
                              @endforeach
                            </td>
                          </tr>
                        </table>
                      @endif
                    @elseif($clearPhrase !== '')
                      <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top:14px;">
                        <tr>
                          <td style="font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:14px;line-height:21px;color:#333333;">
                            {{ $clearPhrase }}
                          </td>
                        </tr>
                      </table>
                    @endif
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        @endfor

        <tr><td style="height:8px;line-height:8px;font-size:0;">&nbsp;</td></tr>

        @php
          $advItems = [
              ['icon' => 'images/test/reprotest-ic-1.svg', 'title' => 'Психоэмоциональное состояние', 'text' => 'Защита от стресса и&nbsp;нормализация&nbsp;сна'],
              ['icon' => 'images/test/reprotest-ic-2.svg', 'title' => 'Микрофлора кишечника и детоксикация', 'text' => 'Нормализация кишечной микрофлоры и поддержка печени'],
              ['icon' => 'images/test/reprotest-ic-3.svg', 'title' => 'Метаболизм и энергия', 'text' => 'Коррекция энергетического обмена и&nbsp;нормализация метаболизма'],
              ['icon' => 'images/test/reprotest-ic-4.svg', 'title' => 'Репродуктивное здоровье', 'text' => 'Поддержка репродуктивной функции'],
          ];
        @endphp

        <tr>
          <td style="padding:0 20px 16px 20px;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" bgcolor="#ffffff" style="background-color:#ffffff;border:1px solid #ecf2f7;border-radius:16px;">
              <tr>
                <td style="padding:24px;">
                  <h2 style="margin:0 0 10px 0;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:20px;line-height:26px;font-weight:700;color:#1a1a1a;">
                    Позаботьтесь о вашем организме с системой РЕПРО!
                  </h2>
                  <p style="margin:0 0 8px 0;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:15px;line-height:22px;color:#333333;font-weight:600;">
                    Программа подойдет и тем, кто не&nbsp;планирует беременность, но хочет понимать, что&nbsp;организм работает как&nbsp;часы.
                  </p>
                  <p style="margin:0 0 8px 0;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:14px;line-height:21px;color:#333333;">
                    Система рекомендаций от линейки продуктов РЕПРО – это программа, которая нормализует дефициты и помогает восстановить важные функции в&nbsp;организме женщины и мужчины, может повысить шансы на успешное зачатие, в&nbsp;том числе методом ЭКО.
                  </p>
                  <p style="margin:0 0 18px 0;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:14px;line-height:21px;color:#333333;">
                    Восстановление организма проходит на&nbsp;нескольких этапах:
                  </p>

                  <!--[if mso]>
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                  <![endif]-->
                  @foreach($advItems as $i => $item)
                    @php
                      $isLeft = $i % 2 === 0;
                      $cellPadding = $isLeft ? 'padding:0 8px 18px 0;' : 'padding:0 0 18px 8px;';
                      $advIconUrl = $imgUrl($item['icon']);
                      $isLast = $i === count($advItems) - 1;
                      $cellClass = 'adv-cell' . ($isLast ? ' adv-cell--last' : '');
                    @endphp
                    @if($isLeft && $i > 0)
                      <!--[if mso]></tr><tr><![endif]-->
                    @endif
                    <!--[if mso]>
                    <td valign="top" width="50%" style="width:50%;{{ $cellPadding }}">
                    <![endif]-->
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="{{ $isLeft ? 'left' : 'right' }}" width="48%" class="{{ $cellClass }}" style="width:48%;mso-hide:all;">
                      <tr>
                        <td valign="top" style="padding:0;">
                          @if($advIconUrl !== '')
                          <img src="{{ $advIconUrl }}" alt="" width="56" height="56" style="display:block;border:0;outline:none;text-decoration:none;width:56px;height:56px;margin:0 0 10px 0;">
                          @endif
                          <h3 style="margin:0 0 6px 0;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:15px;line-height:20px;font-weight:700;color:#1a1a1a;">
                            {!! $item['title'] !!}
                          </h3>
                          <p style="margin:0;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:13px;line-height:19px;color:#4e515c;">
                            {!! $item['text'] !!}
                          </p>
                        </td>
                      </tr>
                    </table>
                    <!--[if mso]></td><![endif]-->
                    @if(! $isLeft)
                      <div style="clear:both;font-size:0;line-height:0;">&nbsp;</div>
                    @endif
                  @endforeach
                  <!--[if mso]>
                    </tr>
                  </table>
                  <![endif]-->
                  <div style="clear:both;font-size:0;line-height:0;">&nbsp;</div>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <tr>
          <td align="center" style="padding:0 20px 10px 20px;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0">
              <tr>
                <td align="center" valign="top" style="padding:0 10px;"><a target="_blank" href="https://rutube.ru/channel/48557140/?utm_term=testirovanie&utm_campaign=reproductivnoe_zdorovie&utm_medium=email&utm_source=site_test&utm_content=utm_email" style="text-decoration:none;"><img title="Rutube" src="{{ asset('storage/email/osen/rutube.png') }}" alt="RT" height="32" width="32" style="display:block;border:0;outline:none;text-decoration:none;"></a></td>
                <td align="center" valign="top" style="padding:0 10px;"><a target="_blank" href="https://t.me/reprobad?utm_term=testirovanie&utm_campaign=reproductivnoe_zdorovie&utm_medium=email&utm_source=site_test&utm_content=utm_email" style="text-decoration:none;"><img title="Telegram" src="{{ asset('storage/email/osen/tg.png') }}" alt="Tg" height="32" width="32" style="display:block;border:0;outline:none;text-decoration:none;"></a></td>
                <td align="center" valign="top" style="padding:0 10px;"><a target="_blank" href="https://ok.ru/group/70000030861851?utm_term=testirovanie&utm_campaign=reproductivnoe_zdorovie&utm_medium=email&utm_source=site_test&utm_content=utm_email" style="text-decoration:none;"><img title="Ok" src="{{ asset('storage/email/osen/ok.png') }}" alt="Ok" height="32" width="32" style="display:block;border:0;outline:none;text-decoration:none;"></a></td>
                <td align="center" valign="top" style="padding:0 10px;"><a target="_blank" href="https://vk.com/club228615718?utm_term=testirovanie&utm_campaign=reproductivnoe_zdorovie&utm_medium=email&utm_source=site_test&utm_content=utm_email" style="text-decoration:none;"><img title="VK" src="{{ asset('storage/email/osen/vk.png') }}" alt="VK" height="32" width="32" style="display:block;border:0;outline:none;text-decoration:none;"></a></td>
                <td align="center" valign="top" style="padding:0 10px;"><a target="_blank" href="http://dzen.ru/reprobad?utm_term=testirovanie&utm_campaign=reproductivnoe_zdorovie&utm_medium=email&utm_source=site_test&utm_content=utm_email" style="text-decoration:none;"><img title="Dzen" src="{{ asset('storage/email/osen/dzen.png') }}" alt="DZ" height="32" width="33" style="display:block;border:0;outline:none;text-decoration:none;"></a></td>
              </tr>
            </table>
          </td>
        </tr>

        <tr>
          <td align="center" style="padding:0 20px 30px 20px;">
            <p style="margin:0;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:12px;line-height:18px;color:#666666;">
              Письмо отправлено в соответствии с <a target="_blank" href="{{ url('/privacy') }}?utm_term=testirovanie&utm_campaign=reproductivnoe_zdorovie&utm_medium=email&utm_source=site_test&utm_content=utm_email" style="color:#1376C8;text-decoration:underline;">пользовательским соглашением</a>.<br>
              Нашли ошибку? <a target="_blank" href="mailto:reproapotheka@rpharm.ru?subject=Ошибка%20на%20сайте%20reprobad.com" style="color:#1376C8;text-decoration:underline;">Напишите нам.</a>
            </p>
            <p style="margin:14px 0 0 0;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;font-size:11px;line-height:16px;color:#888888;">
              БАД. НЕ ЯВЛЯЕТСЯ ЛЕКАРСТВЕННЫМ СРЕДСТВОМ.<br>
              ИМЕЮТСЯ ПРОТИВОПОКАЗАНИЯ. НЕОБХОДИМО ПРОКОНСУЛЬТИРОВАТЬСЯ СО СПЕЦИАЛИСТОМ.
            </p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>
</body>
</html>
