<?php
class Validator
{
     public function prepareAddAppointment($payload)
    {
	  if (isset($payload['author'])&&isset($payload['name'])
		&&isset($payload['expired'])&&isset($payload['dates'])
		&& !empty($payload['author'])&& !empty($payload['name'])) {
	
		$author= htmlspecialchars($payload['author']);
		$name= htmlspecialchars($payload['name']);
		$expired= htmlspecialchars($payload['expired']);
		$dates= $payload['dates'];
	  }else{ echo 'json error';
	  }
	  return compact('author','name','expired','dates');
    }
    public function prepareInsertComment($payload)
{
    if (isset($payload['name']) && isset($payload['commentString']) && isset($payload['appointmentId'])
        && !empty($payload['name']) && !empty($payload['commentString'])) {

        $name = htmlspecialchars($payload['name']);
        $commentString = htmlspecialchars($payload['commentString']);
        $appointmentId = $payload['appointmentId'];
    } else {
        echo 'json error';
    }
    return compact('name', 'commentString', 'appointmentId');
}
public function prepareInsertDates($payload)
{
    if (isset($payload['dates']) && isset($payload['appointmentId']) && !empty($payload['dates'])) {

        $dates = array_map(function($date) {
            return [
                'day' => htmlspecialchars($date['day']),
                'starttime' => htmlspecialchars($date['starttime']),
                'endtime' => htmlspecialchars($date['endtime']),
                'persons' => htmlspecialchars($date['persons'])
            ];
        }, $payload['dates']);

        $appointmentId = $payload['appointmentId'];
    } else {
        echo 'json error';
    }
    return compact('dates', 'appointmentId');
}
public function prepareUpdatePersons($payload)
{
    if (isset($payload['dateId']) && isset($payload['persons']) && !empty($payload['persons'])) {

        $dateId = $payload['dateId'];
        $persons = array_map('htmlspecialchars', $payload['persons']);
    } else {
        echo 'json error';
    }
    return compact('dateId', 'persons');
}

}