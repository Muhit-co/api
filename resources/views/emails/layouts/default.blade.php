<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>
        @yield('title')
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>
  <body style="margin: 0; padding: 0; background-color: #eeeeee;">

    <table border="0" cellpadding="0" cellspacing="0" width="0" style="width: auto; max-width: 700px; display: block; margin: 0 auto; padding: 20px;">
      <tr>
        <td>
          <div style="padding: 20px 30px; background-color: #fff; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;">
            <div style="font-family: Arial, sans-serif; color: #ccccdd; font-size: 13px; text-align: right;">
              {!! trans('email.automated_message_from_muhit', array('tagstart' => '<a href="http://www.muhit.co" target="_blank" style="color: #ccccdd;">', 'tagend' => '</a>' )) !!}
            </div>
            <h3 style="font-family: Arial, sans-serif; color: #44a1e0;">
                @yield('title')
            </h3>
            <div style="font-family: Arial, sans-serif; color: #245672; line-height: 1.5em;">

                @yield('content')

            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td style="text-align: center; padding: 20px 0;">
          <a href="http://muhit.co" target="_blank">
            @include('emails.partials.logo')
          </a>
        </td>
      </tr>
    </table>
  </body>
</html>