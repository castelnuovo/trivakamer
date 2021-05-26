<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Validators\RoomValidator;
use CQ\DB\DB;
use CQ\Controllers\Controller;
use CQ\Response\HtmlResponse;
use CQ\Response\JsonResponse;
use CQ\Response\RedirectResponse;
use CQ\Response\Respond;

final class RoomController extends Controller
{
    /**
     * View room
     */
    public function view(string $roomId): HtmlResponse|RedirectResponse
    {
        $room = DB::get(
            table: 'rooms',
            columns: [
                'id',
                'description',
                'price_monthly',
                'size_m2',
                'address',
                'published_at',
                'updated_at',
                'created_at'
            ],
            where: ['id' => $roomId]
        );

        if (!$room) {
            return Respond::redirect(
                url: '/'
            );
        }

        return Respond::twig(
            view: 'room.twig',
            parameters: [
                'room' => $room
            ]
        );
    }

    /**
     * Update room
     */
    public function update(string $roomId): JsonResponse
    {
        try {
            // TODO: RoomValidator::update($this->request->data);
        } catch (\Throwable) {
            return Respond::prettyJson(
                message: 'Provided data was malformed',
                code: 422
            );
        }

        $room = DB::get(
            table: 'rooms',
            columns: [
                'price_monthly',
                'size_m2',
                'address',
                'published_at',
            ],
            where: ['id' => $roomId]
        );

        if (!$room) {
            return Respond::prettyJson(
                message: 'Room not found',
                data: [
                    'reload' => true
                ],
                code: 404
            );
        }

        $data = [
            'price_monthly' => $this->request->data->price_monthly ?: $room['price_monthly'],
            'size_m2' => $this->request->data->size_m2 ?: $room['size_m2'],
            'address' => $this->request->data->address ?: $room['address'],
        ];

        if (!$room['published_at']) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }

        DB::update(
            table: 'rooms',
            data: $data,
            where: [
                'id' => $roomId,
            ]
        );

        return Respond::prettyJson(
            message: 'Room Updated',
            data: [
                'room' => $data,
                'inputsDisabled' => false,
                'reload' => true // TODO: temporary
            ]
        );
    }

    /**
     * Delete unpublished rooms
     */
    public function delete(string $roomId): JsonResponse
    {
        $room = DB::get(
            table: 'rooms',
            columns: [
                'published_at',
            ],
            where: ['id' => $roomId]
        );

        if (!$room) {
            return Respond::prettyJson(
                message: 'Room not found',
                code: 404
            );
        }

        if ($room['published_at']) {
            return Respond::prettyJson(
                message: 'Can not delete published rooms',
                code: 404
            );
        }

        DB::delete(
            table: 'rooms',
            where: ['id' => $roomId]
        );

        return Respond::prettyJson(
            message: 'Room deleted',
            data: [
                'reload' => true // TODO: temporary
            ]
        );
    }
}
