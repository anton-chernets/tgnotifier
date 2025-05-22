<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateOrCreateUserJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TelegramWebhookController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/telegram/webhook",
     *     summary="Handle Telegram webhook",
     *     tags={"Telegram"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="object",
     *                 @OA\Property(
     *                     property="from",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=11111111),
     *                     @OA\Property(property="first_name", type="string", example="Anton"),
     *                 ),
     *                 @OA\Property(property="text", type="string", example="/start"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Webhook handled successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true)
     *         )
     *     )
     * )
     */
    public function handle(Request $request, ): JsonResponse
    {
        UpdateOrCreateUserJob::dispatch($request->all());

        return response()->json(['status' => true]);
    }
}
