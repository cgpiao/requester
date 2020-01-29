<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Requester
{
   public function handle(Request $request, Closure $next)
   {
      if (config('requester.debug_only') && config('app.debug')) {
         $serverNo = config('requester.server_no');
         $ip = $request->ip();
         $requester = md5($serverNo.$ip.microtime(true).random_int(10, 99));
         $msg = config('requester.pattern');
         if (strpos($msg, 'serverNo') !== false) {
            $msg = str_replace('serverNo', $serverNo, $msg);
         }
         if (strpos($msg,'ip') !== false) {
            $msg = str_replace('ip', $ip, $msg);
         }
         preg_match('/\[(.*?)\]/', $msg, $match);
         if (count($match) === 2) {
            $msg = str_replace($match[1], (new \DateTime())->format($match[1]), $msg);
         }
         $msg = str_replace('requester', $requester, $msg);
         $request->attributes->set('requester', trim($msg));
      }

      return $next($request);
   }
}
