<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BadChoice\Thrust\Facades\Thrust;
use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use App\Ticket;

class ThrustActionsController extends Controller
{
    //
    public function toggle($resourceName, $id, $field)
    {
        $resource  = Thrust::make($resourceName);
        $object    = $resource->find($id);
        $object->update([$field => ! $object->{$field}]);
        return back();
    }

    public function create($resourceName)
    {
        $action      = $this->findActionForResource($resourceName, request('action'));
        if (! $action) {
            abort(404);
        }

        return view('thrust::actions.create', [
            'action'        => $action,
            'resourceName'  => $resourceName,
            'ids'           => request('ids')
        ]);
    }

    public function perform($resourceName)
    {
        $action     = $this->findActionForResource($resourceName, request('action'));
        $ids        = is_string(request('ids')) ? explode(',', request('ids')) : request('ids');
        $response   = $action->handle($action->resource->find($ids));
        $tickets = Ticket::with('user', 'requester')->whereIn('id', $ids)->get();
        \Log::info($tickets);
        $counter = count($tickets);
        $message = $counter.' tickets has been updated!';
        $this->notificationToolBox($tickets, $message);
        if (request()->ajax()) {
            return response()->json(['ok' => true, 'message' => $response ?? 'done']);
        }
        return back()->withMessage($response);
    }

    protected function notificationToolBox($data, $message = 'New ticket has been created!')
    {
        try {
            $client = new Client();
            $api_url = getenv('NOTIFICATION_API');
            $api_token = getenv('NOTIFICATION_API_TOKEN');
            $response = $client->get($api_url, [
                'headers' => [
                    'Authorization' => 'Bearer '.$api_token
                ],
                'query'=>[
                  'type'=>'update',
                  'message'=>$message,
                  'data'=>json_encode($data)
                ]
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function findActionForResource($resourceName, $actionClass)
    {
        $resource   = Thrust::make($resourceName);
        $action     =  collect($resource->actions())->first(function ($action) use ($actionClass) {
            return $action instanceof $actionClass;
        });
        $action->resource = $resource;
        return $action;
    }
}
