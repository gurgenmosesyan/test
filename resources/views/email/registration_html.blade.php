<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <!-- NAME: 2:1 COLUMN - BANDED -->
    <!--[if gte mso 15]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Title</title>

    <style>
        body,
        body * {
            color: #263238;
            font-family: 'Arian AMU', 'Arial AMU', 'Arial', 'tahoma', sans-serif;
        }
    </style>

</head>
<body style="margin: 0; padding: 0;">

<div style="background: #F5F5F5; padding: 25px 25px 40px;">
    <div style="margin-bottom: 20px; text-align: center;">
        <img src="{{url('/favicon.png')}}" style="vertical-align: top;">
        <h2 style="display: inline-block; line-height: 31px; margin: 0 0 0 10px; vertical-align: top;">{{trans('www.email.head_title')}}</h2>
    </div>
    <div style="background: #ffffff; box-shadow: 0 0 8px #ccc; border: 1px solid #ccc; border-top: 4px solid #FFA000; max-width: 500px; margin: 0 auto; padding: 25px;">
        <h3 style="font-weight: bold; margin: 0 0 25px 0; text-align: left;">{{trans('www.email.hello').' '.$email->to_name.','}}</h3>
        <p style="margin-bottom: 30px; text-align: left;">{{trans('www.email.registration.text')}}</p>
        <div style="text-align: center;">
            <a href="{{$email->body}}" style="background-color: #FFA000; border-radius: 4px; color: #ffffff;
                      cursor: pointer; display: inline-block; font-size: 14px; height: 33px; text-transform: uppercase;
                      line-height: 33px; padding: 0 10px; letter-spacing: 1px; text-decoration: none;">
                {{trans('www.email.verify_email')}}
            </a>
        </div>

        <div style="background: #ccc; height: 1px; margin: 40px 0;"></div>

        <p style="margin-bottom: 15px; text-align: left;">{{trans('www.email.registration.text.2')}}</p>

        <a href="{{$email->body}}" style="word-break: break-all; text-align: left;">{{$email->body}}</a>

        <p style="margin: 50px 0 8px; text-align: left;">{{trans('www.email.best_regards')}}</p>
        <p style="font-weight: bold; margin: 0; text-align: left;">{{trans('www.email.team_title')}}</p>

    </div>
</div>

</body>
</html>