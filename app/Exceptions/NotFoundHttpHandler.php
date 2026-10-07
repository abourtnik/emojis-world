<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Foundation\Configuration\Exceptions;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Str;

class NotFoundHttpHandler
{
    public static function register(Exceptions $exceptions): void
    {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if (self::isApiRequest($request)) {
                return response()->json(['message' => self::message($e)], 404);
            }

            return null;
        });
    }

    private static function isApiRequest(Request $request): bool
    {
        return $request->getHost() === config('app.api_url');
    }

    private static function message(NotFoundHttpException $e): string
    {
        $previous = $e->getPrevious();

        if ($previous instanceof ModelNotFoundException) {

            $model = Str::of($previous->getModel())->classBasename();

            return __(':model Not Found', ['model' => $model]);
        }

        return __('Resource Not Found');
    }
}
