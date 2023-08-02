<?php
    require_once './vendor/autoload.php';

    class GoogleCloud
    {
        public function AuthenticateGoogleCalendar(): Google\Service\Calendar
        {
            $google_client = new Google\Client();
            $google_client -> setApplicationName($applicationName = '');
            $google_client -> setScopes($scope_or_scopes = Google\Service\Calendar::CALENDAR_READONLY);
            $google_client -> setAuthConfig($config = '.json');

            return new Google_Service_Calendar($clientOrConfig = $google_client);
        }
    }

    $google_calendar_client = new GoogleCloud();
    $google_calendar_client = $google_calendar_client -> AuthenticateGoogleCalendar();

    $today = new DateTimeImmutable($datetime = 'now', $timezone = new DateTimeZone($timezone = 'JST'));
    $options = array(
        'timeMin' => $today -> format('c'),
        'maxResults' => 2500, // 上限 2,500件
        'orderBy' => 'startTime',
        'singleEvents' => true
    );

    $results = array();
    $event_list = $google_calendar_client -> events -> listEvents(
        $calendarId = '',
        $optParams = $options
    );

    while(true) {
        foreach ($event_list -> getItems() as $event) {
            $start_date = new DateTimeImmutable($datetime = $event -> getStart() -> getDateTime(), $timezone = new DateTimeZone($timezone = 'JST'));
            $end_date = new DateTimeImmutable($datetime = $event -> getEnd() -> getDateTime(), $timezone = new DateTimeZone($timezone = 'JST'));

            array_push($results, array(
                    'ID' => $event -> getId(),
                    'タイトル' => $event -> getSummary(),
                    '開始時間' => $start_date -> format($format = 'Y-m-d H:i（e）'),
                    '終了時間' => $end_date -> format($format = 'Y-m-d H:i（e）'),
                    '場所' => $event -> getLocation(),
                    '備考' => $event -> getDescription(),
                    'URL' => $event -> getHtmlLink()
                )
            );
        }

        $page_token = $event_list -> getNextPageToken();
        if ($page_token) {
            $event_list = $google_calendar_client -> events -> listEvents(
                $calendarId = '',
                $optParams = $options
            );
        } else {
            break;
        }
    }

    print_r($value = $results);
