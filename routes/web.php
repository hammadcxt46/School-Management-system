<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;

Route::get('/qz/sign-message', function (Request $request) {
    $toSign = $request->input('request');

    // Aap ki Private Key Text Format mein
    $privateKey = <<<EOD
-----BEGIN PRIVATE KEY-----
MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQC77NaEYNgGST87
QheySFAoMHr9aJYBCElLsFuyLOAeVMXq+xbfh9CL4SrQtdDAIV99jTdkCzXWI2t2
MVDKhrfxR9MmXkXldWOZqJjr7o8D190dyGbIthpCh+HLnVwsCugG2bV8JdzOzEGO
+3cU1Zxy1osrsMl6wycxOLKM8xB471XVtZZvfhShsmUEeZykG0a+XYKrK93bdwzI
mzplBXPdwL0b6lVgXjDh5wV8FL0pqZAuWdFG7RL+RuHFrpzXEWDW5Ql9uNHjogp4
j/pCFGVtAOheulHiAVTjf5JeNJJ8zh9IHhWKI5/d31altwIb3ki+z9Y8sZ00vMUi
pCYOH93rAgMBAAECggEABx+ORBH4WPNRfRlfaj0ZI2TZt0hNw01BRf1chG+fW9b3
x5VBQ94ojAd6xtLVeQBALTNQoa9Wbj8FIEOfSIX8a/NpMApLw6EEUlCUjKuMFT0L
Sck3stegPYcGtTVKR0sZ329E1KdfbCFMQjNgS1Rg1pjbnp+CtkS2dBmuPu8ptS5r
TzWz2klOqdmwtQZtd1DD9nqYRR3pU/SAejjRED5AwmoWIjvTp3OokM9Nkn/OCf3q
pHSznhgNqIcNpr/Ku+pXzDVp8KVZ1Ct4H1TI+PAHBGAysoLuknL58bdNE9z3QCT1
Tl2E4tCde3zu9MdbDUkpvi+wt2jHn0TZcPgScES1kQKBgQDgIH/9M2HQff5Us37Y
0zyPxxDst/QyaaZeCSJ2nFxNIXNTbTI0ipEQ5txzV0oTwF3kVNo9wCA48ebuwPe8
TAcgI334di2S7TBXmRxaGxwQ9HD7F1zOdF1P6BlXU3Sn37eUCR061f0WIU2Ldo/f
O0qNL58/ftQO3TiSzOz17qFqmwKBgQDWpmK/Es3djSz5EquarD7IW1KxFSeU/ixa
22/51CuHo6voO4cRz/JTPEUd8BfGi22Cn9+l7OP+1G4DxIS1ma7J6PxBGO4KrbFN
uuUJwh2oKOFdhBExvKjxUEFOua1WjMjC7g5qCGD4/Q4HiLU2OCq4EjGcucLLHui4
Um8Gur6m8QKBgQDREcASo3GlGUK8JEw5WqLtw9Yn21kyBZeptH+vgSAg2wlHU183
3+J+j7wo4844KoPrULPcUnI8bHrtUJhHz+v9sN37fdH5csRbknn+G7fMoRkbQKnT
9Hxu46Vv7muthWUr9GyNy7uwfxRk+g4vQJHErh2xD1AlJXt2hS6uIxHz7QKBgQCy
Vy3GGWaIBErwaq2/ZgsHxrCOxsfLR98sYhPIG5tLKBalbggMKZzpwTKf7CKk6KVF
GXXlU0wfJvp9EOM+SwDpazVjFMZ6gtPEhFrV371qQQT2AMuUam5niMmqEiVNusz3
AHljabDATuhAJDqDYOlFZIBp+gE5aGXs9zid+7x50QKBgQCqqNjof05IlTPWaSXK
VzeyenyLqd0uRLF+PVBLF5I2BYSkN93wAL9rkURloXNCPY8Rg5KJQXcZLZab68Dx
OkL75thdrwV0Ul9wqJqavfeNIrQnRGTQlXXPCnc8sIPCwQxMTmAncVpNj1yzuewd
2AMIHEbtpYQ1wLzGfDG+sVeaLw==
-----END PRIVATE KEY-----
EOD;

    // OpenSSL se private key ke zariye signature generate karein
    $key = openssl_pkey_get_private($privateKey);
    $signature = '';
    openssl_sign($toSign, $signature, $key, OPENSSL_ALGO_SHA512);
    openssl_free_key($key);

    return response(base64_encode($signature))->header('Content-Type', 'text/plain');
});
// Private key khatam
Route::get('/', function () {
    return view('welcome');
}) ->name('home');

//define routes to take inputs of student requests
Route::get('/guest/request', [HomeController::class, 'requestfrm']) 
        -> name('guest.request');
Route::post('/guest/request/store', [HomeController::class,'store']) 
        ->name('request.store');


//route for generating receipt of payment
Route::get('/feepayment/invoice/{payment}', [InvoiceController::class, 'invoice']) 
        -> name('feepayment.invoice.download');


