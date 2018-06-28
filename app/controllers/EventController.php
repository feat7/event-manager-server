<?php

namespace app\controllers;

use system\controllers\Controller;
use app\models\User;
use app\models\Event;
use app\models\Registration;
use \app\libs\Auth;


/**
* EventController
*/
class EventController extends Controller
{
	public function __construct()
	{
		$this->middleware('Auth');

		if(!$this->AuthMiddleware->check()) {
			echo json_encode(['success' => false, 'message' => 'Login to access.']);
			exit;
		}
	}
	// REST APIs first

	public function create() {

		$name = $this->post('name');
		$date = $this->post('date');
		$time = $this->post('time');
		$event_type = $this->post('event_type');
		$location = $this->post('location');

		$eventModel = new Event;
		$data = [
			'user_id' => Auth::id(),
			'name' => $name,
			'date' => $date,
			'time' => $time,
			'event_type' => $event_type,
			'location' => $location,
		];
		if($event = $eventModel::create($data)) {
			$json = [
				'success' => true,
				'message' => 'Input Validated. Event Registered',
				'event' => $event->toArray()
			];
		} else {
			$json = [
				'success' => false
			];
		}

		echo json_encode($json);
	}

	public function all() {
		$json = [
			'success' => true,
			'events' => Event::all()->toArray()
		];
		echo json_encode($json);
	}

	public function register() {
		if($this->isPost()) {
			return $this->registerForEvent();
		}
		echo json_encode(['success' => false, 'message' => 'Check method type!']);
	}

	public function registerForEvent()
	{
		$event_id = $this->post('event_id');
		$registration_type = $this->post('registration_type');
		$no_of_tickets = $this->post('no_of_tickets');


		if($this->isPost())
		{

			$eventRegisterModel = new Registration;
			$data = [
				'user_id' => Auth::id(),
				'event_id' => $event_id,
				'registration_type' => $registration_type,
				'no_of_tickets' => $no_of_tickets,
			];
			if($registration = $eventRegisterModel::create($data)) {
				$json = [
					'success' => true,
					'message' => 'Input Validated. User Registered for event',
					'user' => $registration->toArray()
				];
			} else {
				$json = [
					'success' => false,
					'message' => 'Error. Unable to save in database',
				];
			}
			//Return json now
			echo json_encode($json);
		} else {
			echo json_encode(['success' => false, 'message' => 'Validation Error.']);
		}
	}
}