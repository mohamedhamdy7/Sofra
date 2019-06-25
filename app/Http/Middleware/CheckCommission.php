<?php

namespace App\Http\Middleware;

use Closure;

class CheckCommission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $comission=$request->user()->orders()->where('status','deliverd')->sum('comission');

        $pay_off=$request->user()->payments()->sum('pay_off');

        $remaining=$comission-$pay_off;

        if ($remaining>=400){

            return responseJson(0,'تم ايقاف حسابك مؤقتا الى حين سداد العموله لوصولها للحد الاقصى ، يرجى مراجعة صفحة العمولة او مراجعة ادارة التطبيق شاكرين لكم استخدام تطبيق سفره');
        }
        return $next($request);
    }
}
