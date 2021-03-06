<?php

namespace App\Http\Controllers\Api;

use App\Actions\Event\AddEventAction;
use App\Actions\Event\AddEventRequest;
use App\Actions\Event\DeleteEventAction;
use App\Actions\Event\DeleteEventRequest;
use App\Actions\Event\GetEventCollectionAction;
use App\Actions\Event\GetEventCollectionRequest;
use App\Actions\Event\GetEventsEmailsAction;
use App\Actions\Event\GetEventsEmailsRequest;
use App\Actions\Event\UpdateEventAction;
use App\Actions\Event\UpdateEventRequest;
use App\Http\Presenters\EventPresenter;
use App\Http\Presenters\EventsEmailsPresenter;
use App\Http\Requests\Api\Event\EventRequest;
use App\Http\Requests\Api\Event\UpdateEventRequest as UpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends ApiController
{
    private AddEventAction $addEventAction;
    private UpdateEventAction $updateEventAction;
    private DeleteEventAction $deleteEventAction;
    private GetEventCollectionAction $getEventCollectionAction;
    private GetEventsEmailsAction $getEventsEmailsAction;
    private EventPresenter $eventPresenter;

    public function __construct(
        AddEventAction $addEventAction,
        UpdateEventAction $updateEventAction,
        DeleteEventAction $deleteEventAction,
        GetEventCollectionAction $getEventCollectionAction,
        GetEventsEmailsAction $getEventsEmailsAction,
        EventPresenter $eventPresenter
    ) {
        $this->addEventAction = $addEventAction;
        $this->updateEventAction = $updateEventAction;
        $this->deleteEventAction = $deleteEventAction;
        $this->getEventCollectionAction = $getEventCollectionAction;
        $this->getEventsEmailsAction = $getEventsEmailsAction;
        $this->eventPresenter = $eventPresenter;
    }

    public function store(EventRequest $request): JsonResponse
    {
        $response = $this->addEventAction->execute(
            new AddEventRequest(
                (int)$request->event_type_id,
                $request->invitee_name,
                $request->invitee_email,
                $request->start_date,
                $request->timezone,
                $request->custom_field_values,
                $request->invitee_information
            )
        );

        return $this->successResponse($this->eventPresenter->present($response->getEvent()), JsonResponse::HTTP_CREATED);
    }

    public function index(Request $request)
    {
        $response = $this->getEventCollectionAction->execute(
            new GetEventCollectionRequest(
                $request->query('start_date'),
                $request->query('end_date'),
                $request->query('event_types'),
                $request->query('event_emails'),
                $request->query('event_status'),
                $request->query('tags'),
                $request->query('searchString'),
                (int)$request->query('page'),
                (int)$request->query('per_page'),
                $request->query('sort'),
                $request->query('direction')
            )
        );

        return $this->createPaginatedResponse(
            $response->getPaginator(),
            $this->eventPresenter
        );
    }

    public function update(string $id, UpdateRequest $request): JsonResponse
    {
        $response = $this->updateEventAction->execute(
            new UpdateEventRequest(
                (int)$id,
                Auth::id(),
                (int)$request->get('event_type_id'),
                $request->get('invitee_name'),
                $request->get('invitee_email'),
                $request->get('start_date'),
                $request->get('timezone'),
                $request->get('location'),
                $request->get('status'),
                $request->get('custom_field_value')
            )
        );

        return $this->successResponse($this->eventPresenter->present($response->getEvent()));
    }

    public function getEventsEmails(
        Request $request,
        EventsEmailsPresenter $eventsEmailsPresenter
    ) {
        $response = $this->getEventsEmailsAction->execute(
            new GetEventsEmailsRequest(
                $request->query('start_date'),
                $request->query('end_date'),
                $request->query('searchString')
            )
        );

        return $this->successResponse(
            $eventsEmailsPresenter->presentCollection($response->getEvent())
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $this->deleteEventAction->execute(
            new DeleteEventRequest((int)$id, Auth::id())
        );

        return $this->emptyResponse();
    }
}
